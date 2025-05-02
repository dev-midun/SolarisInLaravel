import BaseInput from "./base-input";

export default class TextInput extends BaseInput {
    constructor(selector) {
        super(selector)

        this._error = this._element.classList.contains("is-invalid")
        this._valid = this._element.classList.contains("is-valid")
        this._visible = !this._element.classList.contains("d-none") || !this._element.getAttribute("hidden")
        this._disabled = this._element.disabled
        this._oldValue = this.get()
    }

    static supportedEvent() {
        return ["input", "change", "keydown", "keyup", "keypress", "focus", "blur"]
    }

    /**
     * get current value element
     * @returns {string}
     */
    get() {
        return this._element.value
    }

    /**
     * set value element
     * @param {string} value 
     * @param {boolean} isSilent. trigger change event, default is false 
     */
    set(value, isSilent = false) {
        this._element.value = value

        const isChanged = this.isChanged()
        this._oldValue = value
        if(!isSilent && isChanged) {
            this.trigger('change', this.get())
        }
    }
}