import DataTable from "datatables.net-dt"
import Helper from "./helper"
import axios from "../libs/axios"
import SolarUISingleton from "./solar-ui-singleton"
import Model from "./model"
import Filter from "./filter"

export default class Table {
    _table = null
    _columnHeader = null
    _columns = null
    _extendColumns = null
    _columnDefs = null
    _model = null
    _events = []
    _initFilter = null
    _filter = null
    _dataTable = null
    _currentSort = null
    _nextPage = null
    _prevPage = null
    _currentPage = null
    _horizontal = false
    _info = null
    _info_default = "Showing _start_ to _end_ of _recordsDisplay_ entries"
    _info_empty = "No entries available"
    _info_notFound = "No entries found for your search"
    _info_filtered = "(filtered from _recordsTotal_ total entries)"
    _perPage = 5
    _selected_info = null
    _selected = []
    _excludeSelected = []
    _selectall = false
    _selectallFiltered = false
    _new = null
    _search = null
    _refresh = null
    _deleteAll = null
    #isReady = false
    #isFiltered = false

    constructor(selector) {
        if(selector instanceof HTMLTableElement) {
            this._table = selector
        } else if(Helper.isString(selector) && !Helper.isEmpty(selector)) {
            this._table = document.querySelector(selector)
            if(!this._table) {
                throw new Error(`Element with query selector ${selector} is not found`)
            }

            if(!(this._table instanceof HTMLTableElement)) {
                throw new Error(`Selector is not table element`)
            }
        } else {
            throw new Error(`Selector is not table element`)
        }

        this.#preInit()
        if(!this._table.getAttribute("lazy")) {
            this.init()
        }
    }

    static supportedEvent() {
        return [
            "new", // when new button clicked 
            "view", // when action view clicked
            "edit", // when action edit clicked
            "delete", // when action delete clicked
            "deleted", // when delete function is success
            "init", // when datatable is ready, use it before init Table
            "draw", // when draw callback
            "row created", // when row created, use it before init table. callback param: row, data, dataIndex
            "row click",
            "row dblclick",
            "row contextmenu",
            "column created", // when cell created, use it before init table, using column created:column_name for specific column. callback param: td, cellData, rowData, row, col,
            "column click", 
            "column dblclick",
            "column contextmenu"
        ]
    }

    #preInit() {
        this._currentSort = {index: null, order: "asc"}
        this._columnHeader = this._table.querySelectorAll("thead tr th")
        this._info = document.querySelector(`#${this._table.id}_info`)
        this._selected_info = document.querySelector(`#${this._table.id}_selected_info`)
        this._prevPage = document.querySelector(`#${this._table.id}_pagination nav ul li a.prev-paginate`)
        this._nextPage = document.querySelector(`#${this._table.id}_pagination nav ul li a.next-paginate`)
        this._currentPage = document.querySelector(`#${this._table.id}_pagination nav ul li a.current-paginate`)
        this._model = this._table.getAttribute("model")
        this._perPage = parseInt(this._table.getAttribute("page") ?? this._perPage)
        this._horizontal = this._table.getAttribute("horizontal") ? true : false
        this._extendColumns = this._table.getAttribute("extend-columns")?.split(",").map(col => {
            const name = col.trim()
            return {
                name: name,
                data: name,
                searchable: false,
                orderable: false,
                isLookup: name.endsWith("_id")
            }
        }) ?? []
    
        this._filter = new Filter()
        this._initFilter = this._table.getAttribute("filter")
        if(this._initFilter) {
            this._initFilter = JSON.parse(this._initFilter)
            this._initFilter.forEach(filter => {
                const splitFilter = filter.split(":")
                const columnName = splitFilter[0]
                const columnValue = splitFilter[1]

                this._filter.and(columnName, columnValue)
            })
        }

        this.#getColumns()
        this.#handleSort()
        this.#handlePaginationAction()

        setTimeout(() => {
            const solarUI = SolarUISingleton.getInstance()
            this._new = solarUI.get(`${this._table.id}_new`)
            if(this._new) {
                this._new.click(() => {
                    if(!this.#isReady) {
                        return
                    }

                    this.new()
                })
            }

            this._deleteAll = solarUI.get(`${this._table.id}_selected_delete`)
            if(this._deleteAll) {
                this._deleteAll.click(async () => {
                    if(!this.#isReady) {
                        return
                    }

                    await this.deleteSelected()
                })
            }

            this._search = solarUI.get(`${this._table.id}_search`)
            if(this._search) {
                this._search.on("search", (keywoard) => {
                    if(!this.#isReady) {
                        return
                    }

                    this.search(keywoard)
                })
            }

            this._refresh = solarUI.get(`${this._table.id}_refresh`)
            if(this._refresh) {
                this._refresh.click(() => {
                    if(!this.#isReady) {
                        return
                    }

                    this.refresh()
                })
            }
        }, 0)
    }

    init() {
        this.#columnCallback()

        const config = {
            layout: null,
            pageLength: this._perPage,
            processing: true,
            columns: this._columns.map(col => {
                const newCol = Object.assign({}, col)
                newCol.orderable = false
                return newCol
            }),
            scrollX: this._horizontal,
            columnDefs: this._columnDefs,
            createdRow: (row, data, dataIndex) => {
                this.trigger("row created", row, data, dataIndex)
            },
            initComplete: async (settings, json) => {
                await this.#initCallback(settings, json)
                this.#isReady = true
            }
        }
        if(this._model) {
            config.serverSide = true
            config.ajax = async (data, callback, settings) => {
                const fetchData = await this.#fetchData(data, settings)
                callback({
                    draw: data.draw,
                    recordsTotal: fetchData.recordsTotal,
                    recordsFiltered: fetchData.recordsFiltered,
                    data: fetchData.data
                })
            }
        }

        this._dataTable = new DataTable(this._table, config)
        this._dataTable.on("draw", async (e, settings) => {
            await this.#drawCallback(e, settings)
        })
        this._dataTable.on("processing", (e, settings, processing) => Helper.loadingPage(processing))
        this._dataTable.on("click", `tbody tr`, async (e) => this.trigger("row click", e))
        this._dataTable.on("dblclick", `tbody tr`, async (e) => this.trigger("row dblclick", e))
        this._dataTable.on("contextmenu", `tbody tr`, async (e) => {
            if(!this._events.find(event => event.type == "row contextmenu")) {
                return
            }
            
            e.preventDefault()
            this.trigger("row contextmenu", e)
        })

        this.#handleCheckedAction()
        this.#handleAction()
    }

    async #initCallback(settings, json) {
        const pageInfo = settings.api.page.info()
        if(pageInfo.pages > 1) {
            this._nextPage?.parentElement.classList.remove("disabled")
        }

        if(pageInfo.recordsDisplay == 0) {
            this._currentPage?.classList.add("d-none")
        }

        if(this._info) {
            this._info.textContent = this.compileTextInfo(pageInfo.recordsTotal > 0 ? this._info_default : this._info_empty, pageInfo)
        }

        this.#handleActionDropdown()
        await this.trigger("init", settings, json)
    }

    async #drawCallback(e, settings) {
        if(this._search) {
            this.#isFiltered = !Helper.isEmpty(this._search.get())
        }

        this.#handleAutoIncrement()
        this.#handleChecked()
        this.#handleInfo()
        this.#handlePagination()
        this.#handleActionDropdown()

        await this.trigger("draw", e, settings)
    }

    async #columnCallback() {
        this._columnDefs = []
        this._events.filter(event => event.type.startsWith("column"))
            .forEach((event) => {
                const type = event.type
                const splitType = type.split(":")
                const columnEvent = splitType[0] 
                const columnName = splitType.length > 1 ? splitType[1] : null
                if(!columnName) {
                    return
                }

                const colIndex = this._columns.findIndex(col => col.name == columnName)
                if(colIndex == -1) {
                    console.warn(`on ${columnEvent} for column ${columnName} not found`)
                    return
                }

                const columnDefs = {
                    targets: colIndex,
                    data: this._columns[colIndex].data ?? null,
                    createdCell: (td, cellData, rowData, row, col) => {
                        this.trigger(`column created:${columnName}`, td, cellData, rowData)
                        if(this._events.find(e => e.type == `column click:${columnName}`)) {
                            td.addEventListener("click", (e) => {
                                this.trigger(`column click:${columnName}`, td, cellData, rowData)
                            })
                        }

                        if(this._events.find(e => e.type == `column dblclick:${columnName}`)) {
                            td.addEventListener("dblclick", (e) => {
                                this.trigger(`column dblclick:${columnName}`, td, cellData, rowData)
                            })
                        }

                        if(this._events.find(e => e.type == `column contextmenu:${columnName}`)) {
                            td.addEventListener("contextmenu", (e) => {
                                e.preventDefault()
                                this.trigger(`column dblclick:${columnName}`, td, cellData, rowData)
                            })
                        }
                    }
                }

                if(columnEvent == "column render" && columnName) {
                    columnDefs.render = (data, type, row, meta) => {
                        if(type === 'display') {
                            return this.#renderColumn(columnName, data, row)
                        }
    
                        return data
                    }
                }

                const colDefIndex = this._columnDefs.findIndex(colDef => colDef.targets == colIndex)
                if(colDefIndex == -1) {
                    this._columnDefs.push(columnDefs)
                } else {
                    this._columnDefs[colDefIndex] = columnDefs
                }
            })
    }

    #getColumns() {
        this._columns = []
        this._columnHeader.forEach(th => {
            const isSelectAll = th.getAttribute("select_all")
            const isAutoIncrement = th.getAttribute("autoincrement") ? true : false
            const isViewAction = th.getAttribute("view") ? true : false
            const isEditAction = th.getAttribute("edit") ? true : false
            const isDeleteAction = th.getAttribute("delete") ? true : false
            const tdClass = th.getAttribute("td-class")
            const isAction = isViewAction || isEditAction || isDeleteAction

            const column = {}
            if(isSelectAll) {
                column.name = "_select_all"
                column.searchable = false
                column.orderable = false
                column.width = "3%"
                column.render = (data, type, row, meta) => {
                    return this.#getSelectRowRender()
                }
            } else if(isAutoIncrement) {
                column.name = "_autoincrement"
                column.searchable = false
                column.orderable = false
                column.width = "3%"
                column.render = function (data, type, row, meta) {
                    return meta.row + 1
                }
            } else if(isAction) {
                column.name = "_action"
                column.searchable = false
                column.orderable = false
                column.width = "3%"
                column.render = (data, type, row, meta) => {
                    return this.#getActionRender({view: isViewAction, edit: isEditAction, remove: isDeleteAction})
                }
            } else {
                const data = th.getAttribute("data")
                let isLookup = th.getAttribute("lookup") ? true : false
                if(data && data.split(".").length > 1 && !isLookup) {
                    isLookup = true
                }

                let name = th.getAttribute("name")
                if(!name && isLookup) {
                    name = `${data.split(".")[0]}_id`
                } else if(!name) {
                    name = data ?? th.textContent.trim()
                }

                column.name = name
                column.data = data
                column.searchable = th.getAttribute("searchable") ? true : false
                column.orderable = th.getAttribute("orderable") ? true : false
                column.isLookup = isLookup
            }

            if(tdClass) {
                column.className = tdClass
            }

            this._columns.push(column)
        })
    }

    #handleAutoIncrement() {
        const columnIndex = this._columns.findIndex(col => col.name == "_autoincrement")
        if(columnIndex == -1) {
            return
        }

        const startIndex = this._dataTable.page.info().start
        this._dataTable.column(columnIndex, {search: 'applied', order: 'applied'})
            .nodes()
            .each((cell, i) => {
                let no = i + 1
                cell.innerHTML = this._model ? startIndex + no : no
            })
    }

    #handleActionDropdown() {
        const tableBody = document.querySelector(this._horizontal ? `#${this._table.id}_wrapper .dt-scroll-body` : `#${this._table.id}_wrapper .dt-layout-row`)
        const dropdowns = document.querySelectorAll(`#${this._table.id}_wrapper table .dropdown`)

        dropdowns?.forEach(el => {
            el.addEventListener('show.bs.dropdown', (event) => {
                const dropdownItem = el.querySelector('ul')

                let tableHeight = getComputedStyle(tableBody, null).height
                tableHeight = parseFloat(tableHeight.substring(0, tableHeight.length-2))
                const dropdownHeight = 40 * (dropdownItem.children.length) + 70

                if(dropdownHeight > tableHeight) {
                    tableBody.style.paddingBottom = dropdownHeight + 'px'
                }
            })

            el.addEventListener('hide.bs.dropdown', (event) => {
                tableBody.style.paddingBottom = ""
            })
        })
    }

    //#region sort
    
    #handleSort() {
        const debounceSort = Helper.debounce((index, order) => this.sort(index, order))
        this._columnHeader.forEach((th, index, headers) => {
            if(th.classList.contains("orderable")) {
                th.addEventListener("click", () => {
                    const isSame = this._currentSort.index === index
                    const order = isSame && this._currentSort.order === "asc" ? "desc" : (this._currentSort.order === "desc" ? "" : "asc")

                    this._currentSort = { index: index, order: order }
                    headers.forEach(col => col.classList.remove("sorted", "sorted-asc", "sorted-desc"))
                    
                    if(order != "") {
                        th.classList.add("sorted", order == "asc" ? "sorted-asc" : "sorted-desc")
                    }

                    debounceSort(index, order)
                })
            }
        })
    }

    /**
     * sorting table based on column index or column name
     * @param {number|string} colIndex 
     * @param {string} direction 
     */
    sort(colIndex, direction = "asc") {
        if(!Helper.isNumber(colIndex) && !Helper.isString(colIndex)) {
            throw new Error("colIndex must be column index or column name")
        }
        
        if(Helper.isString(colIndex)) {
            colIndex = this._columns.findIndex(col => col.name == colIndex)
        }

        if(colIndex == -1) {
            console.warn(`Column index ${colIndex} not found`)
            return
        }
        
        const column = this._columns[colIndex]
        if(!column.orderable) {
            return
        }

        this._dataTable?.order([[colIndex, direction]]).draw()
    }

    //#endregion

    //#region pagination

    #handleInfo() {
        if(this._info) {
            const pageInfo = this._dataTable.page.info()
            if(pageInfo.recordsTotal != pageInfo.recordsDisplay) {
                this._info.textContent = this.compileTextInfo(pageInfo.recordsTotal > 0 && pageInfo.recordsDisplay == 0 ? this._info_notFound : `${this._info_default} ${this._info_filtered}`)
            } else {
                this._info.textContent = this.compileTextInfo(pageInfo.recordsTotal > 0 ? this._info_default : this._info_empty)
            }
        }
    }

    #handlePagination() {
        const pageInfo = this._dataTable.page.info()
        if(this._currentPage) {
            this._currentPage.textContent = pageInfo.page + 1
        }

        if(pageInfo.page + 1 < pageInfo.pages) {
            this._nextPage?.parentElement.classList.remove("disabled")
        } else {
            this._nextPage?.parentElement.classList.add("disabled")
        }

        if(pageInfo.page > 0) {
            this._prevPage?.parentElement.classList.remove("disabled")
        } else {
            this._prevPage?.parentElement.classList.add("disabled")
        }

        if(pageInfo.recordsDisplay > 0) {
            this._currentPage?.classList.remove("d-none")
        } else {
            this._currentPage?.classList.add("d-none")
        }
    }

    #handlePaginationAction() {
        this._prevPage.addEventListener("click", (e) => {
            if(!this.#isReady) {
                return
            }

            this.prevPage()
        })

        this._nextPage.addEventListener("click", (e) => {
            if(!this.#isReady) {
                return
            }

            this.nextPage()
        })
    }

    paginate(page) {
        this._dataTable?.page(page).draw('page')
    }

    firstPage() {
        this._dataTable?.page('first').draw('page')
    }

    nextPage() {
        this._dataTable?.page('next').draw('page')
    }

    prevPage() {
        this._dataTable?.page('previous').draw('page')
    }

    lastPage() {
        this._dataTable?.page('last').draw('page')
    }

    //#endregion

    //#region action

    #getActionRender({view = false, edit = false, remove = false}) {
        return `<div class="dropdown">
            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></button>
            <ul class="dropdown-menu">
                ${view ? `<li><a class="dropdown-item view-action" href="javascript:void(0);"><i class="ri-eye-line me-1"></i>View</a></li>` : ''}
                ${edit ? `<li><a class="dropdown-item edit-action" href="javascript:void(0);"><i class="ri-pencil-line me-1"></i>Edit</a></li>` : ''}
                ${remove ? `<li><a class="dropdown-item delete-action" href="javascript:void(0);"><i class="ri-delete-bin-fill me-1"></i>Delete</a></li>` : ''}
            </ul>
        </div>`
    }

    #handleAction() {
        const actionIndex = this._columns.findIndex(col => col.name == "_action")
        if(actionIndex != -1) {
            const th = this._columnHeader[actionIndex]
            const action = [th.getAttribute("view"), th.getAttribute("edit"), th.getAttribute("delete")]

            for (const act of action) {
                if(act) {
                    this._dataTable.on("click", `tbody tr td .${act}-action`, async (e) => {
                        const row = e.target.closest('tr')
                        const data = this._dataTable.row(row).data()

                        if(act == "delete") {
                            await this.delete(data?.id ?? data, row)
                        } else {
                            this.trigger(act, data, row)
                        }
                    })
                }
            }
        }
    }

    new() {
        this._new.load()
        this.trigger("new").then(() => this._new.unload())
    }

    async delete(data, row = null) {
        if(this._model) {
            if(await Model.delete(this._model, data)) {
                this.refresh()
                this.trigger("deleted")
            }
        } else {
            this._dataTable.row(row).remove().draw()
        }
    }

    refresh() {
        this._dataTable?.draw('page')
    }

    //#endregion

    //#region select / checked

    #getSelectRowRender() {
        return `<input class="form-check-input check-all" type="checkbox">`
    }

    #handleChecked() {
        const columnIndex = this._columns.findIndex(col => col.name == "_select_all")
        if(columnIndex == -1) {
            return
        }

        if(!this.#isFiltered && this._selectallFiltered) {
            this._selectallFiltered = false
            this._selectall = false
            const checkboxAll = this._columnHeader[columnIndex].querySelector(`input[type="checkbox"].check-all`)
            checkboxAll.click()
        }

        const scope = this
        this._dataTable.rows({search: 'applied', order: 'applied'})
            .nodes()
            .each(function(row, i) {
                const data = this.row(row).data()
                const checkbox = row.querySelector(`input[type="checkbox"].check-all`)
                if(scope._selectall) {
                    if(scope._excludeSelected.length <= 0) {
                        checkbox.checked = true
                        row.classList.add("table-active")
                    } else {
                        const unselectedData = scope._excludeSelected.find(s => s == data.id)
                        if(unselectedData) {
                            checkbox.checked = false
                            row.classList.remove("table-active")
                        } else {
                            checkbox.checked = true
                            row.classList.add("table-active")
                        }
                    }
                } else if(scope._selected.length > 0) {
                    const selectedData = scope._selected.find(s => s == data.id)
                    if(selectedData) {
                        checkbox.checked = true
                        row.classList.add("table-active")
                    }
                }
            })
    }

    #handleCheckedAction() {
        const selectAllIndex = this._columns.findIndex(col => col.name == "_select_all")
        if(selectAllIndex != -1) {
            const selectAllHandler = (e) => {
                const pageInfo = this._dataTable.page.info()
                const checkbox = e.target
                const checked = checkbox.checked

                this._selectall = checked
                this._selectallFiltered = this.#isFiltered ? checked : false
                if(checked) {
                    this._selected = []
                    this._selected_info.textContent = `${pageInfo.recordsDisplay} record selected`
                    this._deleteAll?.show()
                } else {
                    this._excludeSelected = []
                    this._selected_info.textContent = ""
                    this._deleteAll?.hidden()
                }

                this._dataTable.rows({search: 'applied', order: 'applied'})
                    .nodes()
                    .each(function(row, i) {
                        const checkbox = row.querySelector(`input[type="checkbox"].check-all`)
                        checkbox.checked = checked

                        if(checked) {
                            row.classList.add("table-active")
                        } else {
                            row.classList.remove("table-active")
                        }
                    })
            }
            
            // select all
            const selectAll = document.querySelector(`#${this._table.id}_wrapper .dt-scroll-head table thead tr th input[type="checkbox"].check-all`)
            if(selectAll) {
                selectAll.addEventListener("click", selectAllHandler)
            } else {
                this._dataTable.on("click", `thead tr th input[type="checkbox"].check-all`, selectAllHandler)
            }

            // select one
            this._dataTable.on("click", `tbody tr td input[type="checkbox"].check-all`, (e) => {
                const pageInfo = this._dataTable.page.info()
                const checkbox = e.target
                const checked = checkbox.checked
                const row = checkbox.closest('tr')
                const data = this._dataTable.row(row).data()
                const index = this._selected.findIndex(s => (s?.id ?? s) == (data?.id ?? data))

                if(checked) {
                    row.classList.add("table-active")
                    if(this._selectall) {
                        this._excludeSelected.splice(index, 1)
                    } else {
                        this._selected.push(data?.id ?? data)
                    }
                } else {
                    row.classList.remove("table-active")
                    if(this._selectall) {
                        this._excludeSelected.push(data?.id ?? data)
                    } else {
                        this._selected.splice(index, 1)
                    }
                }

                if(this._selectall) {
                    this._selected_info.textContent = `${pageInfo.recordsDisplay-this._excludeSelected.length} record selected`
                    this._deleteAll?.show()
                } else if(this._selected.length > 0) {
                    this._selected_info.textContent = `${this._selected.length} record selected`
                    this._deleteAll?.show()
                } else {
                    this._selected_info.textContent = ""
                    this._deleteAll?.hidden()
                }
            })
        }
    }

    selected() {
        return this._selected
    }

    clearSelected() {
        this._selected = []
    }

    async deleteSelected() {
        if(this._selected.length == 0 && !this._selectall) {
            return
        }

        if(this._selected.length > 0) {
            console.log("Selected record is deleted..")
            return
        }

        if(this._selectall) {
            console.log("Selected all is deleted..")
            return
        }
    }

    //#endregion

    search(keywoard = "") {
        this._dataTable?.search(keywoard.trim().toLowerCase()).draw()
    }

    on(type, callback) {
        if(!this.constructor.supportedEvent().includes(type)) {
            const typeSplit = type.split(":")
            if(typeSplit.length == 1) {
                throw new Error(`Event ${type} does not support`)
            }

            if(!["column created", "column render", "column click", "column dblclick", "column contextmenu"].includes(typeSplit[0])) {
                throw new Error(`Event ${type} does not support`)
            }

            if(type == "column created") {
                throw new Error(`Event column created must have column name, example: "column render:name"`)
            }
        }

        if(!Helper.isFunction(callback)) {
            throw new Error("Callback must be function")
        }

        this._events.push({
            type: type,
            callback: callback
        })

        return this
    }

    #renderColumn(columnName, ...data) {
        const event = this._events.find(event => event.type == `column render:${columnName}`)
        return event ? event.callback(...data) : null
    }

    async trigger(type, ...data) {
        const event = this._events.find(event => event.type == type)
        if(event) {
            return await event.callback(...data)
        }
    }

    getTemplateInfo() {
        return {
            default: this._info_default,
            filtered: this._info_filtered,
            empty: this._info_empty,
            notfound: this._info_notFound,
        }
    }

    compileTextInfo(text, pageInfo = null) {
        const info = this._dataTable ? this._dataTable.page.info() : pageInfo
        return text.replace("_start_", info.start + 1)
            .replace("_end_", info.end)
            .replace("_recordsDisplay_", info.recordsDisplay)
            .replace("_recordsTotal_", info.recordsTotal)
            .replace("_page_", info.page + 1)
            .replace("_pages_", info.pages)
            .replace("_length_", info.length)
    }

    async #fetchData(data, settings) {
        const pageInfo = settings.api.page.info()
        try {
            const body = {
                columns: this._columns
                    .filter(col => !["_select_all", "_autoincrement", "_action"].includes(col.name))
                    .map(col => {
                        return {
                            name: col.name,
                            data: col.data,
                            searchable: col.searchable,
                            orderable: col.orderable,
                            isLookup: col.isLookup
                        }
                    }).concat(this._extendColumns),
                start: pageInfo.start,
                length: pageInfo.length,
                search: this._search?.get() ?? null,
                filter: this._filter.get(),
                order: data.order.filter(o => this._columns[o.column].orderable)
            }
    
            const req = await axios({
                method: "POST",
                url: `${BASE_URL}/${this._model.toLowerCase()}/datatable`,
                data: body
            })
    
            return req.data
        } catch (error) {
            console.error("Error when fecthing data to server", {error})
            Helper.errorAlert({title: "Whoops! 🙀", message: "Looks like something went wrong. Mind trying again?"})
        } finally {
        }
    }
}