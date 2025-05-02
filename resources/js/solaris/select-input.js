import BaseInput from "./base-input";
import Helper from "./helper";

export default class SelectInput extends BaseInput {
    constructor(selector) {
        super(selector)

        this._error = this._element.classList.contains("is-invalid")
        this._visible = !this._element.classList.contains("d-none")
        this._disabled = this._element.disabled
        this._oldValue = this.get()
    }

    static supportedEvent() {
        return ["change"]
    }

    /**
     * get current value element
     * @returns {{id:string, name:string}}
     */
    get() {
        return !Helper.isEmpty(this._element.value) ? {
            id: this._element.value,
            name: this._element.options[this._element.selectedIndex].text
        } : null
    }

    /**
     * set value element
     * @param {string|{id:string, name:string}} value 
     * @param {boolean} isSilent. trigger change event, default is false 
     */
    set(value, isSilent = false) {
        let val = value
        if(val === null) {
            this._element.value = ""
        } else {
            const isLookup = Helper.isLookup(value)
            if(!isLookup && !Helper.isString(value)) {
                throw new Error("Value must be lookup or string for select element")
            }
            
            val = isLookup ? val.id : val
            if(!Array.from(this._element.options).find(opt => opt.value == val)) {
                throw new Error("Value not exists in options")
            }
            this._element.value = val
        }

        const isChanged = this.isChanged()
        this._oldValue = this.get()
        if(!isSilent && isChanged) {
            this.trigger('change', this.get())
        }
    }

    isChanged() {
        const value = this.get()
        return this._oldValue?.id !== value?.id
    }
}