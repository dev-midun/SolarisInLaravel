import SolarUISingleton from "../../solaris/solar-ui-singleton"

(function() {
    const SolarUI = SolarUISingleton.getInstance()
    window.SolarUI = SolarUI

    const lookup3 = SolarUI.get("lookup3")
    const lookup4 = SolarUI.get("lookup4")
    
    setTimeout(() => {
        lookup3.init()
        lookup4.init()
    }, 1000)
})()