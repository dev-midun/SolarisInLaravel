import SolarUISingleton from "../../solaris/solar-ui-singleton"

(function() {
    const SolarUI = SolarUISingleton.getInstance()
    
    const button9 = SolarUI.get("button9")
    const button10 = SolarUI.get("button10")
    const button19 = SolarUI.get("button19")
    const button20 = SolarUI.get("button20")
    const button27 = SolarUI.get("button27")
    const button28 = SolarUI.get("button28")
    const button35 = SolarUI.get("button35")
    const button36 = SolarUI.get("button36")
    const button43 = SolarUI.get("button43")
    const button44 = SolarUI.get("button44")

    button9.load()
    button19.load()
    button27.load()
    button35.load()
    button43.load()

    button10.disabled()
    button20.disabled()
    button28.disabled()
    button36.disabled()
    button44.disabled()
})()