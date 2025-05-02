import BaseInput from "./base-input";
import CheckboxInput from "./checkbox-input";
import Helper from "./helper";
import RadioInput from "./radio-input";

export default class OptionGroupInput extends BaseInput {
    _options = []

    constructor(selector, type) {
        super(selector)

        if(!["radio", "checkbox"].includes(type)) {
            throw new Error(`Option group ${type} is not supported`)
        }

        this._id = this._element.getAttribute("solar-id")
        Array.from(this._element.children).forEach(el => {
            const component = type == "radio" ? new RadioInput(el.firstElementChild) : new CheckboxInput(el.firstElementChild)
            this._options.push(component)
        })

        if(type == "checkbox") {
            this._options.forEach((opt, optIndex, options) => {
                opt.on("change", (data) => {
                    if(data) {
                        options.filter((_opt, _optIndex) => _optIndex != optIndex)
                            .forEach(el => el.set(false, true))
                    }
                })
            })
        }

        // this._error = this._element.classList.contains("is-invalid")
        // this._valid = this._element.classList.contains("is-valid")
        this._visible = !this._element.classList.contains("d-none")
        if(this._element.getAttribute("disabled")) {
            this.disabled()
        }

        this._oldValue = this.get()
    }

    static supportedEvent() {
        return ["change"]
    }

    /**
     * get current value element
     * @returns {{id: string, name: string}}
     */
    get() {
        const checked = this._options
            .filter(opt => opt.get())
            .map(opt => {
                return {
                    id: opt._element.id,
                    name: opt._label.textContent
                }
            })

        return checked.length == 0 ? null : checked[0]
    }

    /**
     * set value element
     * @param {{id:string, name:string}|string} value 
     * @param {boolean} isSilent. trigger change event, default is false 
     */
    set(value, isSilent = false) {
        let val = value
        if(value === null) {
            this._options.forEach(opt => {
                opt.set(false, isSilent)
            })
        } else {
            const isLookup = Helper.isLookup(value)
            if(!isLookup && !Helper.isString(value)) {
                throw new Error(`Value must be lookup or string for option group option`)
            }

            val = isLookup ? val.id : val
            const index = this._options.findIndex(opt => opt._element.id == val)
            const option = this._options[index]
            if(!option) {
                throw new Error(`Element with id ${val} not found`)
            }
            
            option.set(true, isSilent)
            this._options
                .filter(opt => opt._element.id != val)
                .forEach(opt => {
                    opt.set(false, isSilent)
                })
            
            const isChanged = this.isChanged()
            this._oldValue = this.get()
            if(!isSilent && isChanged) {
                this.trigger('change', this.get())
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

        const handler = (e) => callback(this.get())
        this._events.push({
            type: type,
            callback: callback,
            handler: handler
        })

        this._options.forEach(option => {
            option.on("change", handler)
        })
    }

    /**
     * make element disabled
     */
    disabled() {
        this._disabled = true
        this._options.forEach(opt => opt.disabled())
    }

    /**
     * make element enabled
     */
    enabled() {
        this._disabled = false
        this._options.forEach(opt => opt.enabled())
    }

    /**
     * make element looks valid
     */
    valid() {
        this._options.forEach(opt => opt.valid())
        this._error = false
        this._valid = true
    }

    /**
     * make element looks error
     */
    error() {
        this._options.forEach(opt => opt.error())
        this._error = true
        this._valid = false
    }

    resetValidation() {
        this._options.forEach(opt => opt.resetValidation())
        this._error = false
        this._valid = false
    }

    isChanged() {
        const value = this.get()
        return this._oldValue?.id !== value?.id
    }
}