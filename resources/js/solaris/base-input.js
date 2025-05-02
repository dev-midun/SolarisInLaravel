import Helper from "./helper"

export default class BaseInput {
    _id = null
    _element = null
    _events = []
    _visible = true
    _required = false
    _disabled = false
    _valid = false
    _error = false
    _oldValue = null

    constructor(selector) {
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

        this._id = this._element.id
    }

    static supportedEvent() {
        return []
    }

    /**
     * get current value element
     * @returns {*}
     */
    get() {
        throw new Error("Method 'get()' must be implemented in child class.")
    }

    /**
     * set value element
     * @param {*} value 
     * @param {boolean} isSilent. trigger change event, default is false 
     */
    set(value, isSilent = false) {
        throw new Error("Method 'set()' must be implemented in child class.")
    }

    /**
     * add event to element
     * @param {string} type 
     * @param {Function} callback 
     */
    on(type, callback) {
        if(!this.constructor.supportedEvent().includes(type)) {
            throw new Error(`Event ${type} does not support`)
        }

        if(!Helper.isFunction(callback)) {
            throw new Error(`Callback must be function`)
        }

        const handler = (e) => callback(this.get())
        this._events.push({
            type: type,
            callback: callback,
            handler: handler
        })

        this._element.addEventListener(type, handler)
    }

    /**
     * trigger event manually
     * @param {string} type event type 
     * @param {*} data 
     */
    async trigger(type, data) {
        const events = this._events.filter(e => e.type == type)
        for (let i = 0; i < events.length; i++) {
            const event = events[i]
            await event.callback(data ?? this.get())
        }
    }

    /**
     * show element
     */
    show() {
        if(this._element.getAttribute("hidden")) {
            this._element.removeAttribute("hidden")
        }
        this._element.classList.remove("d-none")
        this._visible = true
    }

    /**
     * hidden element
     */
    hidden() {
        this._element.classList.add("d-none")
        this._visible = false
    }

    /**
     * make element required
     */
    required() {
        this._required = true
    }

    /**
     * make element optional
     */
    optional() {
        this._required = false
    }

    /**
     * make element disabled
     */
    disabled() {
        this._disabled = true
        this._element.disabled = true
    }

    /**
     * make element enabled
     */
    enabled() {
        this._disabled = false
        this._element.disabled = false
    }

    /**
     * make element looks valid
     */
    valid() {
        this._element.classList.remove("is-invalid")
        this._element.classList.add("is-valid")
        this._error = false
        this._valid = true
    }

    /**
     * make element looks error
     */
    error() {
        this._element.classList.remove("is-valid")
        this._element.classList.add("is-invalid")
        this._error = true
        this._valid = false
    }

    resetValidation() {
        this._element.classList.remove("is-valid", "is-invalid")
        this._error = false
        this._valid = false
    }
    
    reset(isSilent = false) {
        this.resetValidation()
        this.set(null, isSilent)
    }

    /**
     * check element is required or not
     * @returns {boolean}
     */
    isRequired() {
        return this._required
    }

    /**
     * check element is disabled or not
     * @returns {boolean}
     */
    isDisabled() {
        return this._disabled
    }

    /**
     * check element is display in document or not
     * @returns {boolean}
     */
    isVisible() {
        return this._visible
    }

    /**
     * check element is error or not
     * @returns {boolean} 
     */
    isError() {
        return this._error
    }

    /**
     * check element is valid or not
     * @returns {boolean} 
     */
    isValid() {
        return this._valid
    }

    /**
     * check element is changed or not
     * @returns {boolean}
     */
    isChanged() {
        return this._oldValue !== this.get()
    }

    /**
     * remove all event
     */
    destroy() {
        this._events.forEach(event => {
            this._element.removeEventListener(event.type, event.handler)
        })

        this._events = []
        this._element = null
    }
}