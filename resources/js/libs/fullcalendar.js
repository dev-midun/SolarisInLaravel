import { Calendar, globalPlugins } from '@fullcalendar/core'
import interactionPlugin__default from '@fullcalendar/interaction'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import multiMonthPlugin from '@fullcalendar/multimonth'

globalPlugins.push(interactionPlugin__default, dayGridPlugin, timeGridPlugin, listPlugin, multiMonthPlugin)

export { Calendar as default }