import { registerPlugin } from "@wordpress/plugins"
import colorSettings from "./admin/colorSettings"
import "./scss/admin.scss"
//import headerSettings from './admin/headerSettings';

registerPlugin("plugin-color-settings", {
    icon: null,
    render: colorSettings,
})
