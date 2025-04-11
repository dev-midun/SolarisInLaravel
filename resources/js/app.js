import $ from 'jquery'
import * as Popper from '@popperjs/core'
import * as bootstrap from 'bootstrap'
import Waves from 'node-waves/src/js/waves'
import SimpleBar from 'simplebar'
import ApexCharts from 'apexcharts'
import select2 from 'select2/dist/js/select2.full'
import Swal from 'sweetalert2/dist/sweetalert2.js'
import Pickr from '@simonwep/pickr/dist/pickr.es5.min';

import.meta.glob([
    '../assets/images/**'
])

window.jQuery = window.$ = $
window.Popper = Popper
window.bootstrap = bootstrap
window.SimpleBar = SimpleBar
window.ApexCharts = ApexCharts
window.Swal = Swal
window.Pickr = Pickr

Waves.attach(".btn-wave", ["waves-light"])
Waves.init()
select2()