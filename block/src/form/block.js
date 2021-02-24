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
registerBlockType("cgb/block-flexi-block-form", {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __("Flexi Submission Form"), // Block title.
	icon: "feedback", // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: "flexi", // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [__("Image"), __("submit"), __("form")],
	example: {
		attributes: {
			content: "Generates Flexi Submission form",
		},
	},
	attributes: {
		enable_ajax: {
			type: "boolean",
			default: true,
		},
		flexi_type: {
			type: "string",
			default: "image",
		},
		form_class: {
			type: "string",
			default: "flexi_form_style",
		},
		form_title: {
			type: "string",
			default: "My Form",
		},
		title_label: {
			type: "string",
			default: "Title",
		},
		title_placeholder: {
			type: "string",
			default: "",
		},
		button_label: {
			type: "string",
			default: "Submit",
		},
		category_label: {
			type: "string",
			default: "Select Category",
		},
		cat: {
			type: "number",
			default: 0,
		},
		tag_label: {
			type: "string",
			default: "Insert Tag",
		},
		desp_label: {
			type: "string",
			default: "Description",
		},
		desp_placeholder: {
			type: "string",
			default: "",
		},
		enable_tag: {
			type: "boolean",
			default: false,
		},
		enable_desp: {
			type: "boolean",
			default: false,
		},
		enable_category: {
			type: "boolean",
			default: false,
		},
		enable_file: {
			type: "boolean",
			default: false,
		},
		enable_bulk_file: {
			type: "boolean",
			default: false,
		},
		file_label: {
			type: "string",
			default: "Select File",
		},
		url_label: {
			type: "string",
			default: "Insert oEmbed URL",
		},
		enable_url: {
			type: "boolean",
			default: false,
		},
		enable_security: {
			type: "boolean",
			default: false,
		},
	},

	edit,

	// Render via PHP
	save: function (props) {
		return null;
	},
});
