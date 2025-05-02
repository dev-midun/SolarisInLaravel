import Cleave from "../libs/cleave"
import TextInput from "./text-input"
import Helper from "./helper"

export default class MaskInput extends TextInput {
    _mask = null
    _isNumber = false
    _config = null
    _isDecimal = false
    _isInteger = false
    _decimal = null
    _lowercase = false
    _uppercase = false

    constructor(selector, config = null) {
        super(selector)

        this._config = {}
        const phone = this._element.getAttribute("phone")
        this._isNumber = this._element.getAttribute("number") ? true : false
        if(this._isNumber) {
            const thousandSeparator = this._element.getAttribute("thousand-separator")
            const decimalSeparator = this._element.getAttribute("decimal-separator")
            const decimal = parseInt(this._element.getAttribute("decimal"))
            this._isInteger = decimal == 0
            this._isDecimal = decimal > 0

            this._config.numeral = true
            this._config.numeralThousandsGroupStyle = thousandSeparator ? 'thousand' : 'none'
            this._config.delimiter = thousandSeparator
            this._config.numeralDecimalMark = decimalSeparator
            this._config.numeralDecimalScale = decimal
        } else if(phone) {
            this._config.phone = true
            this._config.phoneRegionCode = phone
        }

        this._config.numericOnly = this._element.getAttribute("numeric") ?? null
        this._config.prefix = this._element.getAttribute("prefix") ?? null
        this._config.creditCard = this._element.getAttribute("credit-card") ? true : false

        const uppercase = this._element.getAttribute("uppercase") ? true : false
        const lowercase = this._element.getAttribute("lowercase") ? true : false
        this._config.uppercase = uppercase && !lowercase
        this._config.lowercase = !uppercase && lowercase

        const blocks = this._element.getAttribute("blocks")?.split(",").map(b => parseInt(b)) ?? null
        this._config.blocks = blocks

        const delimiters = this._element.getAttribute("delimiters")
        try {
            if(delimiters) {
                this._config.delimiters = JSON.parse(delimiters)
            }
        } catch (error) {
            if(delimiters) {
                this._config.delimiter = delimiters
            }
        }

        Object.assign(this._config, config || {})
        this._mask = new Cleave(this._element, this._config)
        console.log({mask: this._mask, config: this._config})

        this._oldValue = this.get()
    }

    get() {
        if(!this._mask) {
            return super.get()
        }

        const rawValue = this._mask.getRawValue()
        if(this._isNumber) {
            return Helper.isNumber(rawValue) ? (this._isDecimal ? parseFloat(rawValue) : parseInt(rawValue)) : 0
        }

        return rawValue
    }

    set(value, isSilent = false) {
        this._mask.setRawValue(value)

        const isChanged = this._isChanged(value)
        this._oldValue = value
        if(!isSilent && isChanged) {
            this.trigger('change', this.get())
        }
    }
}