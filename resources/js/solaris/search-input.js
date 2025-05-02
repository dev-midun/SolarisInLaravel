import Helper from "./helper";
import TextInput from "./text-input";

export default class SearchInput extends TextInput {
    _wrap = null
    _searchIcon = null
    _resetIcon = null

    constructor(selector) {
        super(selector)

        this._wrap = this._element.parentElement
        this._icon = this._wrap.querySelector('a.custom-form-btn')
        if(!this._icon) {
            throw new Error("Icon search not found")
        }
        this._resetIcon = this._icon.children[0]
        this._searchIcon = this._icon.children[1]

        this._resetIcon.addEventListener("click", (e) => {
            this._resetIcon.classList.add("d-none")
            this.set(null, true)
            this.trigger("search", this.get())
        })
        this._searchIcon.addEventListener("click", (e) => this.trigger("search", this.get()))
        this.on("input", (data) => {
            if(!Helper.isEmpty(data)) {
                this._resetIcon.classList.remove("d-none")
            } else {
                this._resetIcon.classList.add("d-none")
            }
        })
        
        this.on("input", Helper.debounce((data) => {
            this.trigger("search", data)
        }, 450))
    }

    static supportedEvent() {
        return TextInput.supportedEvent().concat("search")
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
        // this._eyeButton.removeEventListener('click', () => this.tooglePassword())
    }
}