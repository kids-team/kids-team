/**
 * Adds a metabox for the page color settings
 */

/**
 * WordPress dependencies
 */
import { ColorPalette } from "@wordpress/components"
import { useDispatch, useSelect } from "@wordpress/data"
import { PluginDocumentSettingPanel } from "@wordpress/editor"
import { useEffect, useState } from "@wordpress/element"
import { __ } from "@wordpress/i18n"

const pageColorSettings = () => {
    const postType = useSelect((select) =>
        select("core/editor").getCurrentPostType()
    )

	if(window.pagenow == 'site-editor') return null

    if (!["post", "page", "event"].includes(postType)) return null
    const {
        meta,
        meta: { page_colors },
    } = useSelect((select) => ({
        meta: select("core/editor").getEditedPostAttribute("meta") || {},
    }))

    const colors = useSelect("core/block-editor").getSettings().colors

    const { editPost } = useDispatch("core/editor")

    const [pageColors, setpageColors] = useState(page_colors)

    const setData = (key, data) => {
        setpageColors({ ...pageColors, [key]: data })
    }

    useEffect(() => {
        editPost({
            meta: {
                ...meta,
                page_colors: pageColors,
            },
        })
    }, [pageColors])

    return (
        <PluginDocumentSettingPanel
            name="page-color-settings"
            title={__("Color Settings", "kids-team")}
            className="page-color-settings"
        >
            <h3>{__("Primary Color", "kids-team")}</h3>
            <ColorPalette
                colors={colors}
                value={pageColors?.primary_color}
                onChange={(value) => {
                    setData("primary_color", value)
                }}
                defaultValue="#000000"
                disableCustomColors={false}
            />
        </PluginDocumentSettingPanel>
    )
}

export default pageColorSettings
