import BaseInput from "./base-input";
import Helper from "./helper";

export default class LookupInput extends BaseInput {
    #lookup = null
    _config = null
    _placeholder = null
    _source = null
    _value = null
    _pagination = false
    _map = null
    _param = null

    constructor(selector, config = null) {
        super(selector)

        try {
            const defaultValue = this._element.getAttribute("value")
            if(defaultValue) {
                this._value = JSON.parse(defaultValue.replace(/&amp;quot;/g, '"'))
            }
        } catch (error) {}

        this._config = LookupInput.defaultConfig()
        this._placeholder = this._element.getAttribute("placeholder") ?? "Choose one"
        if(this._placeholder) {
            this._config.placeholder = this._placeholder
        }
        
        let dropdownParent = this._element.getAttribute("dropdown-parent")
        if(dropdownParent) {
            this._config.dropdownParent = $(dropdownParent)
        }

        this._pagination = this._element.getAttribute("pagination") ? true : false
        this._source = this._element.getAttribute("source")
        if(this._source) {
            Object.assign(this._config, LookupInput.ajaxConfig(this._source))
        }

        Object.assign(this._config, config || {})
        this._param = null
        if(this._config.hasOwnProperty("param")) {
            this._param = this._config.param
            delete this._config.param
        }

        this._map = null
        if(this._config.hasOwnProperty("map")) {
            this._map = this._config.map
            delete this._config.map
        }

        this.init(this._config)
    }

    static supportedEvent() {
        return ["change"]
    }

    static defaultConfig() {
        return {
            allowClear: true,
            width: 'resolve'
        }
    }

    static ajaxConfig(source) {
        return {
            ajax: {
                url: `${BASE_URL}/lookup/${source}`,
                type: 'POST',
                dataType: 'JSON',
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": Helper.getCsrfToken()
                },
                delay: 500,
                cache: true
            }
        }
    }

    static buildParam(callback, isPagination = false) {
        const func = (params) => {
            const param = {
                search: params.term
            }

            if(isPagination) {
                param.length = 10
                param.page = params.page || 1 
            }

            if(callback) {
                return JSON.stringify(callback(param))
            }

            return JSON.stringify(param)
        }

        return func
    }

    static processResults(callback = null, isPagination = false) {
        const func = (data) => {
            if(isPagination) {
                data.results = data.results.map(item => ({id: item.id, text: item.name}))

                return data 
            } else {
                data.results = data.map(item => ({id: item.id, text: item.name}))
            }

            if(callback) {
                return callback(data)
            }

            return data
        }

        return func
    }

    init(config) {
        if(this.#lookup) {
            this.#lookup.select2('destroy')
            this.#lookup = null
        }

        if(config.ajax) {
            config.ajax.data = LookupInput.buildParam(this._param, this._pagination)
            config.ajax.processResults = LookupInput.processResults(this._map, this._pagination)
        }

        this.#lookup = $(this._element).select2(config ?? {})
        if(this._value) {
            this.set(this._value, true)
        } else {
            this.#lookup.val(null).trigger('change')
        }

        this._oldValue = this.get()

        const isChanged = () => {
            const value = this.get()
            const isChanged = this.isChanged(value)
            this._oldValue = value

            if(isChanged) {
                this.trigger('change', value)
            }
        }

        $(this._element).on(`select2:select`, (e) => {
            isChanged()
        })

        $(this._element).on(`select2:unselect`, (e) => {
            isChanged()
        })

        $(this._element).on('select2:unselecting', function() {
            $(this).data('unselecting', true)
        })
        
        $(this._element).on('select2:opening', function(e) {
            if ($(this).data('unselecting')) {
                $(this).removeData('unselecting')
                e.preventDefault()
            }
        })
    }

    open() {
        this.#lookup.select2('open')
    }

    /**
     * get current value element
     * @returns {{id:string, name:string}}
     */
    get() {
        const value = this.#lookup.select2("data")
        if(value.length == 0) {
            return null
        }

        const defaultValue = [
            "disabled",
            "element",
            "id",
            "selected",
            "text",
            "_resultId",
        ];

        const lookupValue = {};
        Object.keys(value[0]).forEach((item) => {
            if (!defaultValue.includes(item)) {
                lookupValue[item] = value[0][item];
            }
        });

        lookupValue.id = value[0].id
        lookupValue.name = value[0].text.trim()

        if(this._value) {
            Object.entries(this._value).forEach(([key, value]) => {
                if (!lookupValue.hasOwnProperty(key)) {
                    lookupValue[key] = value
                }
            })
        }

        return !Helper.isEmpty(lookupValue.id) ? lookupValue : null
    }

    /**
     * set value element
     * @param {string|{id:string, name:string}} value 
     * @param {boolean} isSilent. trigger change event, default is false 
     */
    set(value, isSilent = false) {
        const isChanged = this.isChanged(value)
        this._oldValue = value
        this._value = value

        if(value === null) {
            this.#lookup.val(null).trigger('change')
            if(!isSilent && isChanged) {
                this.trigger('change', value)
            }

            return
        }

        const isLookup = Helper.isLookup(value)
        const isString = Helper.isString(value)
        if(!isLookup && !isString) {
            throw new Error("Value must be lookup or string")
        }

        let isValExists = false
        const _value = isLookup ? value.id : value

        if ($(this._element).find(`option[value="${_value}"]`).length) {
            $(this._element)
                .val(_value)
                .trigger('change')
                .trigger({
                    type: 'select2:select',
                    params: {
                        data: value
                    }
                })

            if(!isSilent && isChanged) {
                this.trigger('change', value)
            }

            isValExists = true
        }

        if(this._source && !isValExists) {
            if(isString) {
                throw new Error("Value must be lookup for server side lookup")
            }

            const newOption = new Option(value.name, value.id, true, true)
            $(this._element)
                .append(newOption)
                .trigger('change')
                .trigger({
                    type: 'select2:select',
                    params: {
                        data: value
                    }
                })
            
            if(!isSilent && isChanged) {
                this.trigger('change', value)
            }
        }
    }

    on(type, callback) {
        if(!this.constructor.supportedEvent().includes(type)) {
            throw new Error(`Event ${type} does not support`)
        }

        if(!Helper.isFunction(callback)) {
            throw new Error(`Callback must be function`)
        }

        this._events.push({
            type: type,
            callback: callback
        })
        
        $(this._element).on(`select2:${type}`, (e) => {
            callback(this.get())
        })
    }

    isChanged() {
        const value = this.get()
        return this._oldValue?.id !== value?.id
    }
}