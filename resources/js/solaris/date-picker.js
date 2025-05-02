import BaseInput from "./base-input"
import flatpickr from "flatpickr"
import Helper from "./helper"

export default class DatePicker extends BaseInput {
    #picker = null
    _pickerElement = null
    _mode = "date"
    _range = false
    _config = null

    constructor(selector, mode = "date", config = null) {
        super(selector)
        if(!["datetime", "date", "time"].includes(mode)) {
            throw new Error(`Picker ${mode} mode is not supported`)
        }

        this._mode = mode
        if(this._mode == "datetime") {
            this._config = DatePicker.dateTimeConfig()
        } else if(this._mode == "time") {
            this._config = DatePicker.timeConfig()
        } else {
            this._config = DatePicker.dateConfig()
        }
        
        this._range = this._element.getAttribute("range") ? true : false
        if(this._range && this._mode != "time") {
            this._config.mode = "range"
        }

        Object.assign(this._config, config || {})
        this.#picker = flatpickr(this._element, this._config)
        this._pickerElement = this._mode == "time" ? this._element : this._element.nextElementSibling
        this._oldValue = this.get()
    }
    
    static dateConfig() {
        return {
            altInput: true,
            altFormat: "d M Y",
            dateFormat: "Y-m-d",
            disableMobile: true
        }
    }

    static dateTimeConfig() {
        return {
            enableTime: true,
            altInput: true,
            altFormat: "d M Y G:i K",
            dateFormat: "Y-m-d H:i",
            disableMobile: true
        }
    }

    static timeConfig() {
        return {
            enableTime: true,
            noCalendar: true,
            altFormat: "H:i",
            dateFormat: "H:i:S",
            disableMobile: true
        }
    }

    static supportedEvent() {
        return ["change", "open", "close", "ready", "day-create"]
    }

    /**
     * get current value element
     * @returns {Date}
     */
    get() {
        if(this.#picker.selectedDates.length == 0) {
            return null
        }

        return this.#picker.config.mode == "single" ? (this.#picker.selectedDates[0]) : this.#picker.selectedDates
    }

    /**
     * set value element
     * @param {string|Date} value 
     * @param {boolean} isSilent. trigger change event, default is false 
     */
    set(value, isSilent = false) {
        this.#picker.setDate(value, !isSilent, this.#picker.config.dateFormat)
    }

    /**
     * get current value element in string format
     * @returns {string|Array}
     */
    toString() {
        if(this.#picker.selectedDates.length == 0) {
            return ""
        }

        const value = this.#picker.selectedDates
        const convert = value.map(val => {
            if(this._mode == "datetime") {
                return Helper.dateTimeToString(val)
            }

            if(this._mode == "date") {
                return Helper.dateToString(val)
            }

            if(this._mode == "time") {
                return Helper.timeToString(val)
            }

            return ""
        })
        
        return this.#picker.config.mode == "single" ? convert[0] : convert
    }

    /**
     * add event to element
     * @param {string} type 
     * @param {Function} callback 
     */
    on(type, callback) {
        const supportedEvent = DatePicker.supportedEvent()
        if(!supportedEvent.includes(type)) {
            throw new Error(`Event ${type} does not support`)
        }

        if(!Helper.isFunction(callback)) {
            throw new Error(`Callback must be function`)
        }

        this._events.push({
            type: type,
            callback: callback
        })

        if(type == 'change') {
            this.#picker.config.onChange.push((selectedDates, dateStr, instance) => {
                callback(this.get(), selectedDates)
            })
        } else if(type == 'open') {
            this.#picker.config.onOpen.push((selectedDates, dateStr, instance) => {
                callback(this.get(), selectedDates)
            })
        } else if(type == 'close') {
            this.#picker.config.onChange.push((selectedDates, dateStr, instance) => {
                callback(this.get(), selectedDates)
            })
        } else if(type == 'ready') {
            this.#picker.config.onReady.push((selectedDates, dateStr, instance) => {
                callback(this.get(), selectedDates)
            })
        } else if(type == 'day-create') {
            this.#picker.config.onDayCreate.push((selectedDates, dateStr, instance, dayElem) => {
                callback(this.get(), selectedDates, dayElem)
            })
        }
    }

    /**
     * show element
     */
    show() {
        this._pickerElement.classList.remove("d-none")
        this._visible = true
    }

    /**
     * hidden element
     */
    hidden() {
        this._pickerElement.classList.add("d-none")
        this._visible = false
    }

    /**
     * make element disabled
     */
    disabled() {
        super.disabled()
        this._pickerElement.disabled = true
    }

    /**
     * make element enabled
     */
    enabled() {
        super.enabled()
        this._pickerElement.disabled = false
    }

    /**
     * make element looks valid
     */
    valid() {
        super.valid()
        this._pickerElement.classList.remove("is-invalid")
        this._pickerElement.classList.add("is-valid")
    }

    /**
     * make element looks error
     */
    error() {
        super.error()
        this._pickerElement.classList.remove("is-valid")
        this._pickerElement.classList.add("is-invalid")
    }

    resetValidation() {
        super.resetValidation()
        this._pickerElement.classList.remove("is-valid", "is-invalid")
    }

    /**
     * remove all event
     */
    destroy() {
        this._events = []
        this.#picker.destroy()
        this.#picker = null
    }
}