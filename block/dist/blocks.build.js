/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/*!***********************!*\
  !*** ./src/blocks.js ***!
  \***********************/
/*! no exports provided */
/*! all exports used */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("Object.defineProperty(__webpack_exports__, \"__esModule\", { value: true });\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__block_block_js__ = __webpack_require__(/*! ./block/block.js */ 1);\n/**\n * Gutenberg Blocks\n *\n * All blocks related JavaScript files should be imported here.\n * You can create a new block folder in this dir and include code\n * for that block here as well.\n *\n * All blocks should be included here since this is the file that\n * Webpack is compiling as the input file.\n */\n\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9ibG9ja3MuanM/N2I1YiJdLCJzb3VyY2VzQ29udGVudCI6WyIvKipcbiAqIEd1dGVuYmVyZyBCbG9ja3NcbiAqXG4gKiBBbGwgYmxvY2tzIHJlbGF0ZWQgSmF2YVNjcmlwdCBmaWxlcyBzaG91bGQgYmUgaW1wb3J0ZWQgaGVyZS5cbiAqIFlvdSBjYW4gY3JlYXRlIGEgbmV3IGJsb2NrIGZvbGRlciBpbiB0aGlzIGRpciBhbmQgaW5jbHVkZSBjb2RlXG4gKiBmb3IgdGhhdCBibG9jayBoZXJlIGFzIHdlbGwuXG4gKlxuICogQWxsIGJsb2NrcyBzaG91bGQgYmUgaW5jbHVkZWQgaGVyZSBzaW5jZSB0aGlzIGlzIHRoZSBmaWxlIHRoYXRcbiAqIFdlYnBhY2sgaXMgY29tcGlsaW5nIGFzIHRoZSBpbnB1dCBmaWxlLlxuICovXG5cbmltcG9ydCBcIi4vYmxvY2svYmxvY2suanNcIjtcblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3NyYy9ibG9ja3MuanNcbi8vIG1vZHVsZSBpZCA9IDBcbi8vIG1vZHVsZSBjaHVua3MgPSAwIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTsiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///0\n");

/***/ }),
/* 1 */
/*!****************************!*\
  !*** ./src/block/block.js ***!
  \****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__editor_scss__ = __webpack_require__(/*! ./editor.scss */ 2);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__editor_scss___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__editor_scss__);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__style_scss__ = __webpack_require__(/*! ./style.scss */ 3);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__style_scss___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__style_scss__);\nfunction _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }\n\n/**\n * BLOCK: flexi-block\n *\n * Registering a basic block with Gutenberg.\n * Simple block, renders and saves the same content without any interactivity.\n */\n\n//  Import CSS.\n\n\n\nvar __ = wp.i18n.__; // Import __() from wp.i18n\n\nvar _wp$blocks = wp.blocks,\n    registerBlockType = _wp$blocks.registerBlockType,\n    RichText = _wp$blocks.RichText; // Import registerBlockType() from wp.blocks\n\nvar _wp$editor = wp.editor,\n    ColorPalette = _wp$editor.ColorPalette,\n    AlignmentToolbar = _wp$editor.AlignmentToolbar,\n    BlockControls = _wp$editor.BlockControls,\n    BlockAlignmentToolbar = _wp$editor.BlockAlignmentToolbar,\n    InspectorControls = _wp$editor.InspectorControls;\nvar _wp$components = wp.components,\n    Toolbar = _wp$components.Toolbar,\n    Button = _wp$components.Button,\n    Text = _wp$components.Text,\n    Tooltip = _wp$components.Tooltip,\n    PanelBody = _wp$components.PanelBody,\n    PanelRow = _wp$components.PanelRow,\n    FormToggle = _wp$components.FormToggle,\n    ToggleControl = _wp$components.ToggleControl,\n    ServerSideRender = _wp$components.ServerSideRender,\n    TextControl = _wp$components.TextControl,\n    Disabled = _wp$components.Disabled,\n    RangeControl = _wp$components.RangeControl;\nvar _wp$element = wp.element,\n    Component = _wp$element.Component,\n    Fragment = _wp$element.Fragment;\nvar withState = wp.compose.withState;\n\n/**\n * Register: aa Gutenberg Block.\n *\n * Registers a new block provided a unique name and an object defining its\n * behavior. Once registered, the block is made editor as an option to any\n * editor interface where blocks are implemented.\n *\n * @link https://wordpress.org/gutenberg/handbook/block-api/\n * @param  {string}   name     Block name.\n * @param  {Object}   settings Block settings.\n * @return {?WPBlock}          The block, if it has been successfully\n *                             registered; otherwise `undefined`.\n */\n\nregisterBlockType(\"cgb/block-flexi-block\", {\n\t// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.\n\ttitle: __(\"flexi-block - x1 Block\"), // Block title.\n\ticon: \"shield\", // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.\n\tcategory: \"common\", // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.\n\tkeywords: [__(\"flexi-block — x1 Block\"), __(\"xxx Example\"), __(\"create-guten-block\")],\n\tattributes: {\n\t\tlayout: {\n\t\t\ttype: \"string\",\n\t\t\tdefault: \"regular\"\n\t\t},\n\t\tcolumn: {\n\t\t\ttype: \"number\",\n\t\t\tdefault: 2\n\t\t},\n\t\tperpage: {\n\t\t\ttype: \"number\",\n\t\t\tdefault: 10\n\t\t},\n\t\tpopup: {\n\t\t\ttype: \"boolean\",\n\t\t\tdefault: false\n\t\t}\n\t},\n\n\t/**\n  * The edit function describes the structure of your block in the context of the editor.\n  * This represents what the editor will render when the block is used.\n  *\n  * The \"edit\" property must be a valid function.\n  *\n  * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/\n  *\n  * @param {Object} props Props.\n  * @returns {Mixed} JSX Component.\n  */\n\tedit: function edit(props) {\n\t\tvar setAttributes = props.setAttributes,\n\t\t    attributes = props.attributes,\n\t\t    className = props.className,\n\t\t    focus = props.focus;\n\n\t\tvar column = props.attributes.column;\n\t\tvar perpage = props.attributes.perpage;\n\t\tvar layout = props.attributes.layout; // To bind attribute layout\n\t\tvar popup = props.attributes.popup; // To bind attribute layout\n\n\t\tfunction onChangeLayout(content) {\n\t\t\tprops.setAttributes({ layout: content });\n\t\t}\n\n\t\tfunction onChangeColumn(changes) {\n\t\t\tprops.setAttributes({ column: changes });\n\t\t}\n\n\t\tfunction onChangePerpage(changes) {\n\t\t\tprops.setAttributes({ perpage: changes });\n\t\t}\n\n\t\tfunction toggleAttribute(attribute) {\n\t\t\treturn function (newValue) {\n\t\t\t\tprops.setAttributes(_defineProperty({}, attribute, newValue));\n\t\t\t};\n\t\t}\n\n\t\treturn [wp.element.createElement(\n\t\t\tFragment,\n\t\t\tnull,\n\t\t\twp.element.createElement(\n\t\t\t\t\"div\",\n\t\t\t\t{ className: props.className },\n\t\t\t\twp.element.createElement(\n\t\t\t\t\tInspectorControls,\n\t\t\t\t\tnull,\n\t\t\t\t\twp.element.createElement(\n\t\t\t\t\t\tPanelBody,\n\t\t\t\t\t\t{ title: __(\"Settings One\"), initialOpen: true },\n\t\t\t\t\t\twp.element.createElement(TextControl, {\n\t\t\t\t\t\t\tlabel: \"Input text\",\n\t\t\t\t\t\t\tvalue: layout,\n\t\t\t\t\t\t\tonChange: onChangeLayout\n\t\t\t\t\t\t}),\n\t\t\t\t\t\twp.element.createElement(RangeControl, {\n\t\t\t\t\t\t\tlabel: \"Columns\",\n\t\t\t\t\t\t\tvalue: column,\n\t\t\t\t\t\t\tonChange: onChangeColumn,\n\t\t\t\t\t\t\tmin: 1,\n\t\t\t\t\t\t\tmax: 10\n\t\t\t\t\t\t}),\n\t\t\t\t\t\twp.element.createElement(RangeControl, {\n\t\t\t\t\t\t\tlabel: \"Post Per Page\",\n\t\t\t\t\t\t\tvalue: perpage,\n\t\t\t\t\t\t\tonChange: onChangePerpage,\n\t\t\t\t\t\t\tmin: 1,\n\t\t\t\t\t\t\tmax: 100\n\t\t\t\t\t\t}),\n\t\t\t\t\t\twp.element.createElement(ToggleControl, {\n\t\t\t\t\t\t\tlabel: \"Popup\",\n\t\t\t\t\t\t\tchecked: popup,\n\t\t\t\t\t\t\tonChange: toggleAttribute(\"popup\")\n\t\t\t\t\t\t})\n\t\t\t\t\t)\n\t\t\t\t),\n\t\t\t\twp.element.createElement(\n\t\t\t\t\tDisabled,\n\t\t\t\t\tnull,\n\t\t\t\t\twp.element.createElement(ServerSideRender, {\n\t\t\t\t\t\tblock: \"cgb/block-flexi-block\",\n\t\t\t\t\t\tattributes: attributes\n\t\t\t\t\t})\n\t\t\t\t)\n\t\t\t)\n\t\t)];\n\t},\n\n\t/**\n  * The save function defines the way in which the different attributes should be combined\n  * into the final markup, which is then serialized by Gutenberg into post_content.\n  *\n  * The \"save\" property must be specified and must be a valid function.\n  *\n  * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/\n  *\n  * @param {Object} props Props.\n  * @returns {Mixed} JSX Frontend HTML.\n  */\n\tsave: function save(props) {\n\t\t//props.attributes.button_color //This way get attribute value\n\t\treturn null;\n\t}\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMS5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9ibG9jay9ibG9jay5qcz85MjFkIl0sInNvdXJjZXNDb250ZW50IjpbImZ1bmN0aW9uIF9kZWZpbmVQcm9wZXJ0eShvYmosIGtleSwgdmFsdWUpIHsgaWYgKGtleSBpbiBvYmopIHsgT2JqZWN0LmRlZmluZVByb3BlcnR5KG9iaiwga2V5LCB7IHZhbHVlOiB2YWx1ZSwgZW51bWVyYWJsZTogdHJ1ZSwgY29uZmlndXJhYmxlOiB0cnVlLCB3cml0YWJsZTogdHJ1ZSB9KTsgfSBlbHNlIHsgb2JqW2tleV0gPSB2YWx1ZTsgfSByZXR1cm4gb2JqOyB9XG5cbi8qKlxuICogQkxPQ0s6IGZsZXhpLWJsb2NrXG4gKlxuICogUmVnaXN0ZXJpbmcgYSBiYXNpYyBibG9jayB3aXRoIEd1dGVuYmVyZy5cbiAqIFNpbXBsZSBibG9jaywgcmVuZGVycyBhbmQgc2F2ZXMgdGhlIHNhbWUgY29udGVudCB3aXRob3V0IGFueSBpbnRlcmFjdGl2aXR5LlxuICovXG5cbi8vICBJbXBvcnQgQ1NTLlxuaW1wb3J0IFwiLi9lZGl0b3Iuc2Nzc1wiO1xuaW1wb3J0IFwiLi9zdHlsZS5zY3NzXCI7XG5cbnZhciBfXyA9IHdwLmkxOG4uX187IC8vIEltcG9ydCBfXygpIGZyb20gd3AuaTE4blxuXG52YXIgX3dwJGJsb2NrcyA9IHdwLmJsb2NrcyxcbiAgICByZWdpc3RlckJsb2NrVHlwZSA9IF93cCRibG9ja3MucmVnaXN0ZXJCbG9ja1R5cGUsXG4gICAgUmljaFRleHQgPSBfd3AkYmxvY2tzLlJpY2hUZXh0OyAvLyBJbXBvcnQgcmVnaXN0ZXJCbG9ja1R5cGUoKSBmcm9tIHdwLmJsb2Nrc1xuXG52YXIgX3dwJGVkaXRvciA9IHdwLmVkaXRvcixcbiAgICBDb2xvclBhbGV0dGUgPSBfd3AkZWRpdG9yLkNvbG9yUGFsZXR0ZSxcbiAgICBBbGlnbm1lbnRUb29sYmFyID0gX3dwJGVkaXRvci5BbGlnbm1lbnRUb29sYmFyLFxuICAgIEJsb2NrQ29udHJvbHMgPSBfd3AkZWRpdG9yLkJsb2NrQ29udHJvbHMsXG4gICAgQmxvY2tBbGlnbm1lbnRUb29sYmFyID0gX3dwJGVkaXRvci5CbG9ja0FsaWdubWVudFRvb2xiYXIsXG4gICAgSW5zcGVjdG9yQ29udHJvbHMgPSBfd3AkZWRpdG9yLkluc3BlY3RvckNvbnRyb2xzO1xudmFyIF93cCRjb21wb25lbnRzID0gd3AuY29tcG9uZW50cyxcbiAgICBUb29sYmFyID0gX3dwJGNvbXBvbmVudHMuVG9vbGJhcixcbiAgICBCdXR0b24gPSBfd3AkY29tcG9uZW50cy5CdXR0b24sXG4gICAgVGV4dCA9IF93cCRjb21wb25lbnRzLlRleHQsXG4gICAgVG9vbHRpcCA9IF93cCRjb21wb25lbnRzLlRvb2x0aXAsXG4gICAgUGFuZWxCb2R5ID0gX3dwJGNvbXBvbmVudHMuUGFuZWxCb2R5LFxuICAgIFBhbmVsUm93ID0gX3dwJGNvbXBvbmVudHMuUGFuZWxSb3csXG4gICAgRm9ybVRvZ2dsZSA9IF93cCRjb21wb25lbnRzLkZvcm1Ub2dnbGUsXG4gICAgVG9nZ2xlQ29udHJvbCA9IF93cCRjb21wb25lbnRzLlRvZ2dsZUNvbnRyb2wsXG4gICAgU2VydmVyU2lkZVJlbmRlciA9IF93cCRjb21wb25lbnRzLlNlcnZlclNpZGVSZW5kZXIsXG4gICAgVGV4dENvbnRyb2wgPSBfd3AkY29tcG9uZW50cy5UZXh0Q29udHJvbCxcbiAgICBEaXNhYmxlZCA9IF93cCRjb21wb25lbnRzLkRpc2FibGVkLFxuICAgIFJhbmdlQ29udHJvbCA9IF93cCRjb21wb25lbnRzLlJhbmdlQ29udHJvbDtcbnZhciBfd3AkZWxlbWVudCA9IHdwLmVsZW1lbnQsXG4gICAgQ29tcG9uZW50ID0gX3dwJGVsZW1lbnQuQ29tcG9uZW50LFxuICAgIEZyYWdtZW50ID0gX3dwJGVsZW1lbnQuRnJhZ21lbnQ7XG52YXIgd2l0aFN0YXRlID0gd3AuY29tcG9zZS53aXRoU3RhdGU7XG5cbi8qKlxuICogUmVnaXN0ZXI6IGFhIEd1dGVuYmVyZyBCbG9jay5cbiAqXG4gKiBSZWdpc3RlcnMgYSBuZXcgYmxvY2sgcHJvdmlkZWQgYSB1bmlxdWUgbmFtZSBhbmQgYW4gb2JqZWN0IGRlZmluaW5nIGl0c1xuICogYmVoYXZpb3IuIE9uY2UgcmVnaXN0ZXJlZCwgdGhlIGJsb2NrIGlzIG1hZGUgZWRpdG9yIGFzIGFuIG9wdGlvbiB0byBhbnlcbiAqIGVkaXRvciBpbnRlcmZhY2Ugd2hlcmUgYmxvY2tzIGFyZSBpbXBsZW1lbnRlZC5cbiAqXG4gKiBAbGluayBodHRwczovL3dvcmRwcmVzcy5vcmcvZ3V0ZW5iZXJnL2hhbmRib29rL2Jsb2NrLWFwaS9cbiAqIEBwYXJhbSAge3N0cmluZ30gICBuYW1lICAgICBCbG9jayBuYW1lLlxuICogQHBhcmFtICB7T2JqZWN0fSAgIHNldHRpbmdzIEJsb2NrIHNldHRpbmdzLlxuICogQHJldHVybiB7P1dQQmxvY2t9ICAgICAgICAgIFRoZSBibG9jaywgaWYgaXQgaGFzIGJlZW4gc3VjY2Vzc2Z1bGx5XG4gKiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcmVnaXN0ZXJlZDsgb3RoZXJ3aXNlIGB1bmRlZmluZWRgLlxuICovXG5cbnJlZ2lzdGVyQmxvY2tUeXBlKFwiY2diL2Jsb2NrLWZsZXhpLWJsb2NrXCIsIHtcblx0Ly8gQmxvY2sgbmFtZS4gQmxvY2sgbmFtZXMgbXVzdCBiZSBzdHJpbmcgdGhhdCBjb250YWlucyBhIG5hbWVzcGFjZSBwcmVmaXguIEV4YW1wbGU6IG15LXBsdWdpbi9teS1jdXN0b20tYmxvY2suXG5cdHRpdGxlOiBfXyhcImZsZXhpLWJsb2NrIC0geDEgQmxvY2tcIiksIC8vIEJsb2NrIHRpdGxlLlxuXHRpY29uOiBcInNoaWVsZFwiLCAvLyBCbG9jayBpY29uIGZyb20gRGFzaGljb25zIOKGkiBodHRwczovL2RldmVsb3Blci53b3JkcHJlc3Mub3JnL3Jlc291cmNlL2Rhc2hpY29ucy8uXG5cdGNhdGVnb3J5OiBcImNvbW1vblwiLCAvLyBCbG9jayBjYXRlZ29yeSDigJQgR3JvdXAgYmxvY2tzIHRvZ2V0aGVyIGJhc2VkIG9uIGNvbW1vbiB0cmFpdHMgRS5nLiBjb21tb24sIGZvcm1hdHRpbmcsIGxheW91dCB3aWRnZXRzLCBlbWJlZC5cblx0a2V5d29yZHM6IFtfXyhcImZsZXhpLWJsb2NrIOKAlCB4MSBCbG9ja1wiKSwgX18oXCJ4eHggRXhhbXBsZVwiKSwgX18oXCJjcmVhdGUtZ3V0ZW4tYmxvY2tcIildLFxuXHRhdHRyaWJ1dGVzOiB7XG5cdFx0bGF5b3V0OiB7XG5cdFx0XHR0eXBlOiBcInN0cmluZ1wiLFxuXHRcdFx0ZGVmYXVsdDogXCJyZWd1bGFyXCJcblx0XHR9LFxuXHRcdGNvbHVtbjoge1xuXHRcdFx0dHlwZTogXCJudW1iZXJcIixcblx0XHRcdGRlZmF1bHQ6IDJcblx0XHR9LFxuXHRcdHBlcnBhZ2U6IHtcblx0XHRcdHR5cGU6IFwibnVtYmVyXCIsXG5cdFx0XHRkZWZhdWx0OiAxMFxuXHRcdH0sXG5cdFx0cG9wdXA6IHtcblx0XHRcdHR5cGU6IFwiYm9vbGVhblwiLFxuXHRcdFx0ZGVmYXVsdDogZmFsc2Vcblx0XHR9XG5cdH0sXG5cblx0LyoqXG4gICogVGhlIGVkaXQgZnVuY3Rpb24gZGVzY3JpYmVzIHRoZSBzdHJ1Y3R1cmUgb2YgeW91ciBibG9jayBpbiB0aGUgY29udGV4dCBvZiB0aGUgZWRpdG9yLlxuICAqIFRoaXMgcmVwcmVzZW50cyB3aGF0IHRoZSBlZGl0b3Igd2lsbCByZW5kZXIgd2hlbiB0aGUgYmxvY2sgaXMgdXNlZC5cbiAgKlxuICAqIFRoZSBcImVkaXRcIiBwcm9wZXJ0eSBtdXN0IGJlIGEgdmFsaWQgZnVuY3Rpb24uXG4gICpcbiAgKiBAbGluayBodHRwczovL3dvcmRwcmVzcy5vcmcvZ3V0ZW5iZXJnL2hhbmRib29rL2Jsb2NrLWFwaS9ibG9jay1lZGl0LXNhdmUvXG4gICpcbiAgKiBAcGFyYW0ge09iamVjdH0gcHJvcHMgUHJvcHMuXG4gICogQHJldHVybnMge01peGVkfSBKU1ggQ29tcG9uZW50LlxuICAqL1xuXHRlZGl0OiBmdW5jdGlvbiBlZGl0KHByb3BzKSB7XG5cdFx0dmFyIHNldEF0dHJpYnV0ZXMgPSBwcm9wcy5zZXRBdHRyaWJ1dGVzLFxuXHRcdCAgICBhdHRyaWJ1dGVzID0gcHJvcHMuYXR0cmlidXRlcyxcblx0XHQgICAgY2xhc3NOYW1lID0gcHJvcHMuY2xhc3NOYW1lLFxuXHRcdCAgICBmb2N1cyA9IHByb3BzLmZvY3VzO1xuXG5cdFx0dmFyIGNvbHVtbiA9IHByb3BzLmF0dHJpYnV0ZXMuY29sdW1uO1xuXHRcdHZhciBwZXJwYWdlID0gcHJvcHMuYXR0cmlidXRlcy5wZXJwYWdlO1xuXHRcdHZhciBsYXlvdXQgPSBwcm9wcy5hdHRyaWJ1dGVzLmxheW91dDsgLy8gVG8gYmluZCBhdHRyaWJ1dGUgbGF5b3V0XG5cdFx0dmFyIHBvcHVwID0gcHJvcHMuYXR0cmlidXRlcy5wb3B1cDsgLy8gVG8gYmluZCBhdHRyaWJ1dGUgbGF5b3V0XG5cblx0XHRmdW5jdGlvbiBvbkNoYW5nZUxheW91dChjb250ZW50KSB7XG5cdFx0XHRwcm9wcy5zZXRBdHRyaWJ1dGVzKHsgbGF5b3V0OiBjb250ZW50IH0pO1xuXHRcdH1cblxuXHRcdGZ1bmN0aW9uIG9uQ2hhbmdlQ29sdW1uKGNoYW5nZXMpIHtcblx0XHRcdHByb3BzLnNldEF0dHJpYnV0ZXMoeyBjb2x1bW46IGNoYW5nZXMgfSk7XG5cdFx0fVxuXG5cdFx0ZnVuY3Rpb24gb25DaGFuZ2VQZXJwYWdlKGNoYW5nZXMpIHtcblx0XHRcdHByb3BzLnNldEF0dHJpYnV0ZXMoeyBwZXJwYWdlOiBjaGFuZ2VzIH0pO1xuXHRcdH1cblxuXHRcdGZ1bmN0aW9uIHRvZ2dsZUF0dHJpYnV0ZShhdHRyaWJ1dGUpIHtcblx0XHRcdHJldHVybiBmdW5jdGlvbiAobmV3VmFsdWUpIHtcblx0XHRcdFx0cHJvcHMuc2V0QXR0cmlidXRlcyhfZGVmaW5lUHJvcGVydHkoe30sIGF0dHJpYnV0ZSwgbmV3VmFsdWUpKTtcblx0XHRcdH07XG5cdFx0fVxuXG5cdFx0cmV0dXJuIFt3cC5lbGVtZW50LmNyZWF0ZUVsZW1lbnQoXG5cdFx0XHRGcmFnbWVudCxcblx0XHRcdG51bGwsXG5cdFx0XHR3cC5lbGVtZW50LmNyZWF0ZUVsZW1lbnQoXG5cdFx0XHRcdFwiZGl2XCIsXG5cdFx0XHRcdHsgY2xhc3NOYW1lOiBwcm9wcy5jbGFzc05hbWUgfSxcblx0XHRcdFx0d3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFxuXHRcdFx0XHRcdEluc3BlY3RvckNvbnRyb2xzLFxuXHRcdFx0XHRcdG51bGwsXG5cdFx0XHRcdFx0d3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFxuXHRcdFx0XHRcdFx0UGFuZWxCb2R5LFxuXHRcdFx0XHRcdFx0eyB0aXRsZTogX18oXCJTZXR0aW5ncyBPbmVcIiksIGluaXRpYWxPcGVuOiB0cnVlIH0sXG5cdFx0XHRcdFx0XHR3cC5lbGVtZW50LmNyZWF0ZUVsZW1lbnQoVGV4dENvbnRyb2wsIHtcblx0XHRcdFx0XHRcdFx0bGFiZWw6IFwiSW5wdXQgdGV4dFwiLFxuXHRcdFx0XHRcdFx0XHR2YWx1ZTogbGF5b3V0LFxuXHRcdFx0XHRcdFx0XHRvbkNoYW5nZTogb25DaGFuZ2VMYXlvdXRcblx0XHRcdFx0XHRcdH0pLFxuXHRcdFx0XHRcdFx0d3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFJhbmdlQ29udHJvbCwge1xuXHRcdFx0XHRcdFx0XHRsYWJlbDogXCJDb2x1bW5zXCIsXG5cdFx0XHRcdFx0XHRcdHZhbHVlOiBjb2x1bW4sXG5cdFx0XHRcdFx0XHRcdG9uQ2hhbmdlOiBvbkNoYW5nZUNvbHVtbixcblx0XHRcdFx0XHRcdFx0bWluOiAxLFxuXHRcdFx0XHRcdFx0XHRtYXg6IDEwXG5cdFx0XHRcdFx0XHR9KSxcblx0XHRcdFx0XHRcdHdwLmVsZW1lbnQuY3JlYXRlRWxlbWVudChSYW5nZUNvbnRyb2wsIHtcblx0XHRcdFx0XHRcdFx0bGFiZWw6IFwiUG9zdCBQZXIgUGFnZVwiLFxuXHRcdFx0XHRcdFx0XHR2YWx1ZTogcGVycGFnZSxcblx0XHRcdFx0XHRcdFx0b25DaGFuZ2U6IG9uQ2hhbmdlUGVycGFnZSxcblx0XHRcdFx0XHRcdFx0bWluOiAxLFxuXHRcdFx0XHRcdFx0XHRtYXg6IDEwMFxuXHRcdFx0XHRcdFx0fSksXG5cdFx0XHRcdFx0XHR3cC5lbGVtZW50LmNyZWF0ZUVsZW1lbnQoVG9nZ2xlQ29udHJvbCwge1xuXHRcdFx0XHRcdFx0XHRsYWJlbDogXCJQb3B1cFwiLFxuXHRcdFx0XHRcdFx0XHRjaGVja2VkOiBwb3B1cCxcblx0XHRcdFx0XHRcdFx0b25DaGFuZ2U6IHRvZ2dsZUF0dHJpYnV0ZShcInBvcHVwXCIpXG5cdFx0XHRcdFx0XHR9KVxuXHRcdFx0XHRcdClcblx0XHRcdFx0KSxcblx0XHRcdFx0d3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFxuXHRcdFx0XHRcdERpc2FibGVkLFxuXHRcdFx0XHRcdG51bGwsXG5cdFx0XHRcdFx0d3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFNlcnZlclNpZGVSZW5kZXIsIHtcblx0XHRcdFx0XHRcdGJsb2NrOiBcImNnYi9ibG9jay1mbGV4aS1ibG9ja1wiLFxuXHRcdFx0XHRcdFx0YXR0cmlidXRlczogYXR0cmlidXRlc1xuXHRcdFx0XHRcdH0pXG5cdFx0XHRcdClcblx0XHRcdClcblx0XHQpXTtcblx0fSxcblxuXHQvKipcbiAgKiBUaGUgc2F2ZSBmdW5jdGlvbiBkZWZpbmVzIHRoZSB3YXkgaW4gd2hpY2ggdGhlIGRpZmZlcmVudCBhdHRyaWJ1dGVzIHNob3VsZCBiZSBjb21iaW5lZFxuICAqIGludG8gdGhlIGZpbmFsIG1hcmt1cCwgd2hpY2ggaXMgdGhlbiBzZXJpYWxpemVkIGJ5IEd1dGVuYmVyZyBpbnRvIHBvc3RfY29udGVudC5cbiAgKlxuICAqIFRoZSBcInNhdmVcIiBwcm9wZXJ0eSBtdXN0IGJlIHNwZWNpZmllZCBhbmQgbXVzdCBiZSBhIHZhbGlkIGZ1bmN0aW9uLlxuICAqXG4gICogQGxpbmsgaHR0cHM6Ly93b3JkcHJlc3Mub3JnL2d1dGVuYmVyZy9oYW5kYm9vay9ibG9jay1hcGkvYmxvY2stZWRpdC1zYXZlL1xuICAqXG4gICogQHBhcmFtIHtPYmplY3R9IHByb3BzIFByb3BzLlxuICAqIEByZXR1cm5zIHtNaXhlZH0gSlNYIEZyb250ZW5kIEhUTUwuXG4gICovXG5cdHNhdmU6IGZ1bmN0aW9uIHNhdmUocHJvcHMpIHtcblx0XHQvL3Byb3BzLmF0dHJpYnV0ZXMuYnV0dG9uX2NvbG9yIC8vVGhpcyB3YXkgZ2V0IGF0dHJpYnV0ZSB2YWx1ZVxuXHRcdHJldHVybiBudWxsO1xuXHR9XG59KTtcblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3NyYy9ibG9jay9ibG9jay5qc1xuLy8gbW9kdWxlIGlkID0gMVxuLy8gbW9kdWxlIGNodW5rcyA9IDAiXSwibWFwcGluZ3MiOiJBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///1\n");

/***/ }),
/* 2 */
/*!*******************************!*\
  !*** ./src/block/editor.scss ***!
  \*******************************/
/*! dynamic exports provided */
/***/ (function(module, exports) {

eval("// removed by extract-text-webpack-plugin//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMi5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9ibG9jay9lZGl0b3Iuc2Nzcz80OWQyIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIHJlbW92ZWQgYnkgZXh0cmFjdC10ZXh0LXdlYnBhY2stcGx1Z2luXG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9zcmMvYmxvY2svZWRpdG9yLnNjc3Ncbi8vIG1vZHVsZSBpZCA9IDJcbi8vIG1vZHVsZSBjaHVua3MgPSAwIl0sIm1hcHBpbmdzIjoiQUFBQSIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///2\n");

/***/ }),
/* 3 */
/*!******************************!*\
  !*** ./src/block/style.scss ***!
  \******************************/
/*! dynamic exports provided */
/***/ (function(module, exports) {

eval("// removed by extract-text-webpack-plugin//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMy5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9ibG9jay9zdHlsZS5zY3NzPzgwZjMiXSwic291cmNlc0NvbnRlbnQiOlsiLy8gcmVtb3ZlZCBieSBleHRyYWN0LXRleHQtd2VicGFjay1wbHVnaW5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3NyYy9ibG9jay9zdHlsZS5zY3NzXG4vLyBtb2R1bGUgaWQgPSAzXG4vLyBtb2R1bGUgY2h1bmtzID0gMCJdLCJtYXBwaW5ncyI6IkFBQUEiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///3\n");

/***/ })
/******/ ]);