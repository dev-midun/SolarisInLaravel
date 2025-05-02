import Helper from "./helper"

export default class Button {
    _id = null
    _element = null
    _event = null
    _disabled = false
    _visible = true
    _loading = false

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
        this._visible = this._element.classList.contains("d-none") || this._element.getAttribute("hidden")
    }

    /**
     * add event on click
     * @param {Function} callback 
     */
    click(callback) {
        if(!Helper.isFunction(callback)) {
            throw new Error(`Callback must be function`)
        }

        if(this._event) {
            this._element.removeEventListener("click", this._event)
        }

        this._event = (e) => callback(e)
        this._element.addEventListener("click", this._event)
    }

    hidden() {
        this._element.classList.add("d-none")
        this._visible = false
    }

    show() {
        if(this._element.getAttribute("hidden")) {
            this._element.removeAttribute("hidden")
        }
        this._element.classList.remove("d-none")
        this._visible = true
    }

    disabled() {
        this._element.disabled = true
        this._disabled = true
    }

    enabled() {
        this._element.disabled = false
        this._disabled = false
    }

    load() {
        this._element.classList.add("btn-loader")
        this._element.append(this.#addLoader())
        this._loading = true
        this.disabled()
    }

    unload() {
        this._element.classList.remove("btn-loader")
        const loader = this._element.querySelector("span.loading")
        if(loader) {
            this._element.removeChild(loader)
        }

        this._loading = false
        this.enabled()
    }

    #addLoader() {
        const span = document.createElement("span")
        span.className = "loading ms-2"

        const icon = document.createElement("i")
        icon.className = "ri-loader-4-line"

        span.append(icon)

        return span
    }

    destroy() {
        this._element.removeEventListener("click", this._event)
        this._events = null
    }
}