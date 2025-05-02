import TextInput from "./text-input"

export default class Password extends TextInput {
    _wrap = null
    _eyeButton = null
    _icon = null

    constructor(selector) {
        super(selector)

        this._wrap = this._element.parentElement
        this._eyeButton = this._wrap.querySelector('a.show-password-button')
        if(!this._eyeButton) {
            throw new Error("Icon show password not found")
        }
        this._icon = this._eyeButton.children[0]
        this._eyeButton.addEventListener('click', () => this.tooglePassword())
    }

    /**
     * show/hidden password value
     */
    tooglePassword() {
        if(this._element.type == "password") {
            this._element.type = "text"
            this._icon.classList.remove("ri-eye-line")
            this._icon.classList.add("ri-eye-off-line")
        } else {
            this._element.type = "password"
            this._icon.classList.remove("ri-eye-off-line")
            this._icon.classList.add("ri-eye-line")
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

    /**
     * remove all event
     */
    destroy() {
        super.destroy()
        this._eyeButton.removeEventListener('click', () => this.tooglePassword())
    }
}