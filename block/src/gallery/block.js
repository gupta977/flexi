/**
 * BLOCK: flexi-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import "./editor.scss";
import "./style.scss";

// Import block dependencies and components
import edit from "./edit";

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType, RichText } = wp.blocks; // Import registerBlockType() from wp.blocks
const {
	ColorPalette,
	AlignmentToolbar,
	BlockControls,
	BlockAlignmentToolbar,
	InspectorControls,
} = wp.editor;
const {
	Toolbar,
	Button,
	Text,
	Tooltip,
	PanelBody,
	PanelRow,
	FormToggle,
	SelectControl,
	ToggleControl,
	ServerSideRender,
	TextControl,
	Disabled,
	RangeControl,
} = wp.components;

const { Component, Fragment } = wp.element;
const { withState } = wp.compose;
const { withSelect } = wp.data;

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType("cgb/block-flexi-block", {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __("Flexi Gallery"), // Block title.
	icon: "format-gallery", // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: "flexi", // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [__("Image"), __("gallery"), __("picture")],
	example: {
		attributes: {
			content: "Generates Flexi Gallery shortcode",
		},
	},
	attributes: {
		layout: {
			type: "string",
			default: "masonry",
		},
		tag: {
			type: "string",
			default: "",
		},
		filter: {
			type: "string",
			default: "none",
		},
		cat: {
			type: "number",
			default: 0,
		},
		column: {
			type: "number",
			default: 2,
		},
		perpage: {
			type: "number",
			default: 8,
		},
		padding: {
			type: "number",
			default: 1,
		},
		popup: {
			type: "boolean",
			default: false,
		},
		tag_show: {
			type: "boolean",
			default: false,
		},
		orderby: {
			type: "string",
			default: "asc",
		},
		hover_effect: {
			type: "string",
			default: "",
		},
		hover_caption: {
			type: "string",
			default: "flexi_caption_none",
		},
		width: {
			type: "number",
			default: 150,
		},
		height: {
			type: "number",
			default: 150,
		},
		evalue_title: {
			type: "boolean",
			default: true,
		},
		evalue_excerpt: {
			type: "boolean",
			default: false,
		},
		evalue_custom: {
			type: "boolean",
			default: false,
		},
		evalue_icon: {
			type: "boolean",
			default: true,
		},
	},

	edit,

	// Render via PHP
	save: function (props) {
		return null;
	},
});
