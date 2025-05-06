import Helper from "./helper"
import axios from "../libs/axios"

class Stage {
    _element = null
    _events = null
    id = null
    name = null
    color = null
    currentColor = null
    active = false
    selected = false
    // disabled = false
    button = null
    text = null
    confirm = false
    confirmMessage = "Are you sure ?"

    constructor(selector) {
        if(selector instanceof Element || (Helper.isString(selector) && !Helper.isEmpty(selector))) {
            if(selector instanceof Element) {
                this._element = selector
            } else if(Helper.isString(selector) && !Helper.isEmpty(selector)) {
                this._element = document.querySelector(selector)
                if(!this._element) {
                    throw new Error(`Element with query selector ${selector} is not found`)
                }
            } else {
                throw new Error(`Selector is not supported`)
            }

            this._stageFromElement()
        } else {
            this._stageFromObject(selector)
        }
        
        this._init()
    }

    /**
     * _stageFromElement create stage from HTMLElement
     * @param {HTMLElement} stage
     */
    _stageFromElement() {
        if(!this._element.classList.contains('stage-button')) {
            throw new Error("Stage must be contains class stage-button")
        }

        this.button = this._element.querySelector('button.btn')
        this.text = this.button.querySelector('span.stage-text')
        const color = [...this._element.classList].find(cls => cls.includes("stage-color-"))?.replace("stage-color-", "") ?? "primary"
        if(!this._isValidColor(color)) {
            throw new Error(`Color ${color} is not supported, use "primary, secondary, info, success, warning, danger"`)
        }

        this.id = this._element.dataset.id
        this.name = this.text.textContent
        this.color = color
        this.currentColor = color
        this.active = false
        this.selected = false
        // this.disabled = false
        this.confirm = this._element.dataset.confirm == "true" ? true : false
        this.confirmMessage = this._element.getAttribute('data-confirm-message') ?? this.confirmMessage
    }

    /**
     * _stageFromObject create stage from object
     * @param {{
     *  id: string,
     *  name: string,
     *  color: string,
     *  confirm: boolean
     * }} stage
     */
    _stageFromObject(stage) {
        if(!Helper.isObject(stage)) {
            throw new Error("Stage must be object")
        }

        if(!["id", "name", "color"].every(prop => stage.hasOwnProperty(prop))) {
            throw new Error("Stage must have id, name, color, and element property")
        }

        if(!this._isValidColor(stage.color)) {
            throw new Error(`Color ${stage.color} is not supported, use "primary, secondary, info, success, warning, danger"`)
        }

        this.id = stage.id
        this.name = stage.name
        this.color = stage.color
        this.currentColor = stage.color
        this.active = false
        this.selected = false
        this.action = null
        this.confirm = stage.confirm
        this.confirmMessage = stage.confirmMessage ?? "Are you sure ?"

        this._createElement()
    }

    _isValidColor(color) {
        return ["primary", "secondary", "info", "success", "warning", "danger"].includes(color)
    }

    _createElement() {
        const container = document.createElement('div')
        container.className = `stage-button stage-color-${this.color}`
        container.setAttribute('data-id', this.id)

        const button = document.createElement('button')
        button.className = 'btn'
        button.setAttribute('type', 'button')
        button.setAttribute('data-confirm', this.confirm)

        const text = document.createElement('span')
        text.className = 'stage-text'
        text.textContent = this.name

        button.appendChild(text)
        container.appendChild(button)

        this.element = {
            stage: container,
            button: button,
            text: text
        }
    }

    _init() {
        this._events = []
        this._initOnHover()
        this._initOutHover()
        this._initOnClick()

        setTimeout(() => {
            if(this.text.scrollWidth > this.text.clientWidth) {
                this.button.setAttribute("title", this.text.textContent)
            }
        }, 100)
    }

    _initOnHover() {
        this._element.addEventListener("mouseenter", () => {
            if(this.isDisabled()) {
                return
            }

            this.onHover()
            this.trigger('onhover')
        })
    }

    _initOutHover() {
        this._element.addEventListener("mouseleave", () => {
            if(this.isDisabled()) {
                return
            }

            this.outHover()
            this.trigger('outhover')
        })
    }

    _initOnClick() {
        this.button.addEventListener("click", async () => {
            if(this.isDisabled()) {
                return
            }
            
            if(this.confirm) {
                if(!await Helper.confirm({title: this.confirmMessage})) {
                    return
                }
            }

            const trigger = await this.trigger('click')
            if(typeof trigger === 'boolean' && trigger === true) {
                this.onSelected(true)
            } else if(trigger === undefined || trigger == null) {
                this.onSelected(true)
            }
        })
    }

    setColor(color) {
        this._element.classList.remove(`stage-color-${this.currentColor}`)
        this._element.classList.add(`stage-color-${color}`)
        this.currentColor = color
    }

    onHover() {
        if(!this.selected) {
            this._element.classList.add("stage-hover")
        }
    }

    outHover() {
        this._element.classList.remove("stage-hover")
        if(!this.selected) {
            this._element.classList.remove(`stage-color-${this.currentColor}`)
            this._element.classList.add(`stage-color-${this.color}`)
            this.currentColor = this.color
        }
    }

    onSelected(active = false) {
        this._element.classList.add("stage-selected")
        this.selected = true
        this.active = active
        if(active) {
            this._element.classList.add("stage-active")
            this.setColor(this.color)
        }
    }

    unSelected() {
        this._element.classList.remove("stage-active", "stage-selected")
        this.active = false
        this.selected = false
    }

    disabled() {
        this._element.classList.add("stage-disabled")
    }

    enabled() {
        this._element.classList.remove("stage-disabled")
    }

    isDisabled() {
        return this._element.classList.contains("stage-disabled")
    }

    on(type, callback) {
        if(!["onhover", "outhover", "click"].includes(type)) {
            throw new Error(`Event ${type} is not supported`)
        }

        if(!Helper.isFunction(callback)) {
            throw new Error("Callback must be function")
        }

        const index = this._events.findIndex(event => event.type == type)
        if(index != -1) {
            this._events.splice(index, 1)
        }

        this._events.push({type: type, callback: callback})
    }

    async trigger(type) {
        const event = this._events.find(e => e.type == type)
        if(event) {
            return await event.callback()
        }

        return null
    }
}

class DropdownStage extends Stage {
    activeMenu = null
    constructor(selector) {
        super(selector)
    }

    /**
     * _stageFromElement create stage from HTMLElement
     * @param {HTMLElement} stage
     */
    _stageFromElement() {
        if(!this._element.classList.contains('stage-button') || !this._element.classList.contains('stage-button-dropdown')) {
            throw new Error("Dropdown Stage must be contains class stage-button and stage-button-dropdown")
        }

        const color = [...this._element.classList].find(cls => cls.includes("stage-color-"))?.replace("stage-color-", "") ?? "primary"
        if(!this._isValidColor(color)) {
            throw new Error(`Color ${color} is not supported, use "primary, secondary, info, success, warning, danger"`)
        }

        this.id = this._element.dataset.id
        this.button = this._element.querySelector('button.btn')
        this.text = this.button.querySelector('span span.stage-text')
        this.menu = this._element.parentElement.parentElement.querySelector(`div.dropdown-menu[data-id="${this.id}"]`)
        if(!this.menu) {
            throw new Error("Dropdown menu not found")
        }

        this.name = this.text.textContent
        this.color = color
        this.currentColor = color
        this.active = false
        this.selected = false
        this.confirm = this._element.dataset.confirm == "true" ? true : false
        this.confirmMessage = this._element.getAttribute('data-confirm-message') ?? this.confirmMessage
        this.menuItem = Array.from(this.menu.querySelectorAll('a.dropdown-item')).map(item => {
            return {
                id: item.dataset.id,
                name: item.textContent,
                color: item.dataset.color ?? this.color,
                active: false,
                selected: false,
                confirm: item.dataset.confirm == "true" ? true : this.confirm,
                confirmMessage: item.getAttribute('data-confirm-message') ?? this.confirmMessage,
                action: null,
                element: item
            }
        })
    }

    /**
     * _stageFromObject create stage from object
     * @param {{
     *  id: string,
     *  name: string,
     *  color: string,
     *  menu: Array,
     *  confirm: boolean
     * }} stage
    */
    _stageFromObject(stage) {
        if(!this._container) {
            throw new Error("Container cannot be null")
        }

        if(!Helper.isObject(stage)) {
            throw new Error("Stage must be object")
        }

        if(!["id", "name", "color", "menu"].every(prop => stage.hasOwnProperty(prop))) {
            throw new Error("Stage must have id, name, color, and element property")
        }

        if(!this._isValidColor(stage.color)) {
            throw new Error(`Color ${stage.color} is not supported, use "primary, secondary, info, success, warning, danger"`)
        }

        this.id = stage.id
        this.name = stage.name
        this.color = stage.color
        this.currentColor = stage.color
        this.active = false
        this.selected = false
        this.confirm = stage.confirm
        this.confirmMessage = stage.confirmMessage ?? "Are you sure ?"
        this.menu = stage.menu.map(item => {
            item.active = false
            item.selected = false
            if(!item.hasOwnProperty('color')) {
                item.color = this.color
            }

            if(!item.hasOwnProperty('action')) {
                item.action = null
            }

            if(!item.hasOwnProperty('confirm')) {
                item.confirm = this.confirm
            }

            if(!item.hasOwnProperty('confirmMessage')) {
                item.confirmMessage = this.confirmMessage
            }

            return item
        })

        this._createElement()
    }

    _createElement() {
        const arrowSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 16 16" fit="" preserveAspectRatio="xMidYMid meet" focusable="false">
            <g transform="translate(-1783.779 74.455)">
                <g>
                <g>
                    <path d="M1787.779-67.455l4,4,4-4Z" fill="currentColor"></path>
                </g>
                </g>
            </g>
            <rect width="16" height="16" fill="none"></rect>
        </svg>`

        const container = document.createElement('div')
        container.className = `stage-button stage-button-dropdown stage-color-${this.color}`
        container.setAttribute('data-id', this.id)

        const button = document.createElement('button')
        button.className = 'btn'
        button.setAttribute('type', 'button')
        button.setAttribute('data-confirm', this.confirm)

        const spanText = document.createElement('span')
        spanText.className = "d-flex justify-content-between"

        const text = document.createElement('span')
        text.className = 'stage-text'
        text.textContent = this.name

        const arrow = document.createElement('span')
        arrow.className = 'stage-text-arrow'
        arrow.innerHTML = arrowSvg

        const menu = document.createElement('div')
        menu.className = "dropdown-menu"
        menu.setAttribute('data-id', this.id)

        this.menu.forEach(m => {
            const item = document.createElement('a')
            item.className = "dropdown-item"
            item.setAttribute('href', '#')
            item.setAttribute('data-id', m.id)
            item.setAttribute('data-color', m.color)
            item.textContent = m.name

            menu.appendChild(item)
            m.element = item
        })

        spanText.append(text, arrow)
        button.appendChild(spanText)
        container.appendChild(button)
        this._container.appendChild(menu)

        this.element = {
            stage: container,
            button: button,
            text: text,
            menu: menu
        }
    }

    _initOnHover() {
        super._initOnHover()
        this.menuItem.forEach(item => {
            item.element.addEventListener("mouseenter", () => {
                item.selected = true
                this.trigger('onhover')
            })
        })
    }

    _initOutHover() {
        this._element.addEventListener("mouseleave", () => {
            if(!this.menu.classList.contains('show')) {
                this.outHover()
                this.trigger('outhover')
            }
        })

        this.menuItem.forEach(item => {
            item.element.addEventListener("mouseleave", () => {
                item.selected = false
            })
        })
    }

    _initOnClick() {
        this.button.addEventListener("click", async () => {
            this.menu.style.top = `${this._element.offsetTop + this._element.clientHeight}px`;
            this.menu.style.left = `${this._element.offsetLeft}px`;
            this.menu.classList.toggle('show')
        })

        this.menuItem.forEach((item, index, menus) => {
            item.element.addEventListener('click', async (e) => {
                if(this.isDisabled()) {
                    return
                }

                e.preventDefault()
                if(item.active) {
                    return
                }

                if(item.confirm) {
                    if(!await Helper.confirm({title: item.confirmMessage})) {
                        this.menu.classList.toggle('show')
                        return
                    }
                }

                menus.forEach(m => {
                    m.element.classList.remove('active')
                    m.active = false
                    m.selected = false
                })
                item.active = true

                const trigger = await this.trigger('click')
                if((typeof trigger === 'boolean' && trigger === true) || trigger === undefined || trigger == null) {                    
                    item.element.classList.add('active')
                    item.selected = true
                    this.onSelected(true)
                    this.setColor(item.color)
                    this.text.textContent = item.name
                    this.menu.classList.remove('show')
                    this.activeMenu = item
                } else {
                    menus.forEach(m => {
                        m.element.classList.remove('active')
                        m.active = false
                        m.selected = false
                    })
                    if(this.activeMenu) {
                        this.activeMenu.element.classList.add('active')
                        this.activeMenu.active = true
                        this.activeMenu.selected = true
                        this.outHover()
                        this.trigger('outhover')
                    }
                }
            })
        })

        document.addEventListener("click", (e) => {
            if(!this.menu.contains(e.target) && !this._element.contains(e.target)) {
                this.menu.classList.remove('show')
                this.outHover()
                this.trigger('outhover')
            }
        })
    }

    unSelected() {
        super.unSelected()
        this.text.textContent = this.name
        this.menuItem.forEach(m => {
            m.element.classList.remove('active')
            m.active = false
            m.selected = false
        })
    }
}

export default class StageButtons {
    _element = null
    _events = []
    _disabled = false
    #stages = []
    #source = null

    /**
     * constructor
     * @param {string|HTMLElement} element
     * @param {string|Array} source
     */
    constructor(selector, source = null) {
        if(selector instanceof Element) {
            this._element = selector
        } else if(Helper.isString(selector) && !Helper.isEmpty(selector)) {
            this._element = document.querySelector(selector)
            if(!this._element) {
                throw new Error(`Element with query selector ${selector} is not found`)
            }
        } else {
            throw new Error(`Selector is not supported`)
        }

        this.#source = source
        if(!Helper.isString(source)) {
            this.render()
        }
    }

    /**
     * render element
     * @param {string|Array} source
     */
    async render() {
        if(!this._element.classList.contains('stage-container')) {
            this._element.classList.add('stage-container')
        }

        if(this._element.children.length > 0) {
            this._element.querySelectorAll('div.stage-group .stage-button')
                .forEach(stageElem => {
                    if(!stageElem.classList.contains('stage-button-dropdown')) {
                        this.#stages.push(new Stage(stageElem))
                    } else {
                        this.#stages.push(new DropdownStage(stageElem))
                    }
                })
        } else {
            const stageGroup = document.createElement('div')
            stageGroup.className = "stage-group"
            this._element.appendChild(stageGroup)

            if(Helper.isString(source)) {
                this.#source = await this.#getStageFromServer()
            }

            this.#source.forEach(item => {
                const stage = item.hasOwnProperty('menu') && item.menu.length > 0 ? new DropdownStage(item, this._element) : new Stage(item)
                this.#stages.push(stage)
                stageGroup.appendChild(stage.element.stage)
            })
        }

        this.#stages.forEach((stage, index, stages) => {
            stage.on('onhover', () => {
                if(stage.isDisabled()) {
                    return
                }

                const dropdownOpen = stages.find(s => s instanceof DropdownStage && s.menu.classList.contains('show'))
                if(!(stage instanceof DropdownStage) && dropdownOpen) {
                    dropdownOpen.menu.classList.remove('show')
                    dropdownOpen.outHover()
                    stages.filter(s => s.id != stage.id).forEach(s => s.outHover())
                }

                if(!stage.selected) {
                    for (let i = 0; i <= index; i++) {
                        stages[i].setColor(stage instanceof DropdownStage && dropdownOpen ? stage.menuItem.find(s => s.selected)?.color ?? stage.color : stage.color)
                        stages[i].onHover()
                    }
                }
            })

            stage.on('outhover', () => {
                // const activeStage = stages.find(item => item.active)
                for (let i = 0; i <= index; i++) {
                    // if(activeStage) {
                    //     stages[i].setColor(activeStage.menuItem ? activeStage.menuItem.find(item => item.active)?.color ?? activeStage.color : activeStage.color)
                    // }

                    stages[i].outHover()
                }
            })

            stage.on('click', async () => {
                if(stage.isDisabled()) {
                    return
                }

                const menuActive = stage.menuItem ? stage.menuItem.find(s => s.active) : null
                const data = stage instanceof DropdownStage ? { id: menuActive.id, name: menuActive.name } : { id: stage.id, name: stage.name }
                const action = await this.trigger("click", data)
                if(typeof action === 'boolean' && !action) {
                    return action
                }

                stages
                    .forEach((s, i) => {
                        if(i != index) {
                            s.unSelected()
                        }
                    })

                for (let i = 0; i < index; i++) {
                    stages[i].onSelected()
                    stages[i].setColor(menuActive?.color ?? stage.color)
                }

                this.trigger("change", data)
            })
        })

        const value = this._element.getAttribute("value")
        if(!Helper.isEmpty(value)) {
            this.set(value)
        }
    }

    on(type, callback) {
        if(!["click", "change"].includes(type)) {
            throw new Error(`Event ${type} is not supported`)
        }

        if(!Helper.isFunction(callback)) {
            throw new Error("Callback must be function")
        }

        const index = this._events.findIndex(event => event.type == type)
        if(index != -1) {
            this._events.splice(index, 1)
        }

        this._events.push({type: type, callback: callback})
        return this
    }

    async trigger(type, data = null) {
        const event = this._events.find(e => e.type == type)
        if(event) {
            return await event.callback(data)
        }

        return null
    }

    /**
     * set stage by id/name to active
     * @param {string} id stage id or stage name
     */
    async set(id, isSilent = false) {
        if(id == null) {
            this.#stages.forEach(stage => {
                stage.unSelected()
            })

            return
        }

        let stage = this.#stages.find(item => item.id == id || item.name == id)
        if(!stage) {
            stage = this.#stages.find(item => {
                const dropdown = item instanceof DropdownStage
                const menu = dropdown ? dropdown.menu.find(m => m.id == id || m.name == id) : null
                return menu ? true : false
            })
        }

        if(!stage) {
            throw new Error(`Stage with id or name ${id} not found`)
        }

        if(stage instanceof DropdownStage) {
            const menu = stage.menu.find(s => s.id == id || s.name == id)

            stage.onSelected(true)
            stage.setColor(menu.color)
            stage.element.text.textContent = menu.name
            stage.menu.forEach(m => {
                m.element.classList.remove('active')
                m.active = false
                m.selected = false
            })
            menu.element.classList.add('active')
            menu.active = true
            menu.selected = true
            stage.element.menu.classList.remove('show')
        }

        const action = await stage.trigger('click')
        if(action === true || action === null || action === undefined) {
            stage.onSelected(true)
        }
    }

    /**
     * get current stage active
     * @returns {{id: string, name: string}}
     */
    get() {
        const stage = this.#stages.find(item => item.active)
        if(stage instanceof DropdownStage) {
            const menuActive = stage.menuItem.find(s => s.active)
            return menuActive ? { id: menuActive.id, name: menuActive.name } : null
        }

        return stage ? { id: stage.id, name: stage.name } : null
    }

    setConfirm(id, confirm = true, confirmMessage = "") {
        let stage = this.#stages.find(item => item.id == id || item.name == id)
        if(!stage) {
            stage = this.#stages.find(item => {
                const dropdown = item instanceof DropdownStage
                const menu = dropdown ? dropdown.menu.find(m => m.id == id || m.name == id) : null
                return menu ? true : false
            })
        }

        if(!stage) {
            throw new Error(`Stage with id or name ${id} not found`)
        }

        if(stage instanceof DropdownStage) {
            const menu = stage.menu.find(s => s.id == id)
            menu.confirm = confirm
            if(confirmMessage != "" && confirmMessage != menu.confirmMessage) {
                menu.confirmMessage = confirmMessage
            }
        } else {
            stage.confirm = confirm
            if(confirmMessage != "" && confirmMessage != stage.confirmMessage) {
                stage.confirmMessage = confirmMessage
            }
        }

        return this
    }

    async #getStageFromServer(url) {
        const req = await axios({
            method: 'POST',
            url: `${BASE_URL}/${url}`
        })

        return req.data.map(item => {
            const data = {
                id: item.id,
                name: item.name,
                color: item.color
            }

            if(data.hasOwnProperty('menu') && data.menu.length > 0) {
                data.menu = item.menu
            }

            return data
        })
    }

    disabled() {
        this.#stages.forEach(stage => {
            stage.disabled()
        })
    }

    enabled() {
        this.#stages.forEach(stage => {
            stage.enabled()
        })
    }

    isDisabled() {
        return this._disabled
    }

    reset(isSilent = false) {
        this.set(null, isSilent)
    }
}
