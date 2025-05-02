import BaseInput from "./base-input";

export default class CheckboxInput extends BaseInput {
    _wrap = null
    _label = null

    constructor(selector) {
        super(selector)
        this._wrap = this._element.parentElement
        this._label = this._wrap.querySelector("label")
        this._error = this._element.classList.contains("is-invalid")
        this._valid = this._element.classList.contains("is-valid")
        this._visible = !this._wrap.classList.contains("d-none")
        this._disabled = this._element.disabled
        this._oldValue = this.get()
    }

    static supportedEvent() {
        return ["change"]
    }

    /**
     * get current value element
     * @returns {boolean}
     */
    get() {
        return this._element.checked
    }

    /**
     * set value element
     * @param {boolean} value 
     * @param {boolean} isSilent. trigger change event, default is false 
     */
    set(value, isSilent = false) {
        if(typeof value !== 'boolean') {
            throw new Error("Value must be boolean")
        }

        this._element.checked = value

        const isChanged = this.isChanged(value)
        this._oldValue = this.get()
        if(!isSilent && isChanged) {
            this.trigger('change', this.get())
        }
    }

    /**
     * show element
     */
    show() {
        this._wrap.classList.remove("d-none")
        this._visible = true
    }

    /**
     * hidden element
     */
    hidden() {
        this._wrap.classList.add("d-none")
        this._visible = false
    }

    reset(isSilent = false) {
        this.resetValidation()
        this.set(false, isSilent)
    }
}