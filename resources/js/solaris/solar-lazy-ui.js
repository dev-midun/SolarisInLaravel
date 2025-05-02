import SolarUISingleton from './solar-ui-singleton'

export default class LazyLoadComponent {
    constructor(key, component, param) {
        this.key = key
        this.component = component
        this.param = param ?? []
    }

    /**
     * Init SolarUI Component
     * @param {Array} config 
     */
    init() {
        const solarUI = SolarUISingleton.getInstance()
        solarUI.set(this.key, new this.component(...this.param))
    }
}