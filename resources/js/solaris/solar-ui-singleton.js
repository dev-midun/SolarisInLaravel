import SolarComponent from "./solar-component"

let solarUI = null
export default class SolarUISingleton {

    /**
     * Get SolarUI
     * @returns {SolarComponent}
     */
    static getInstance() {
        if (!solarUI) {
            solarUI = new SolarComponent();
            solarUI.init()
        }

        return solarUI;
    }
}