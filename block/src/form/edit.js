// Import block dependencies and components
import { BuildTree, GroupByParent } from "../helper.js";
// Components
const {
	Disabled,
	PanelBody,
	RangeControl,
	SelectControl,
	ServerSideRender,
	ToggleControl,
	TextControl,
} = wp.components;
const { __ } = wp.i18n; // Import __() from wp.i18n
const { Component, Fragment } = wp.element;

const { InspectorControls } = wp.editor;

const { withSelect } = wp.data;

/**
 * Create an FlexiGalleryEdit Component.
 */
class FlexiGalleryEdit extends Component {
	constructor() {
		super(...arguments);
		this.toggleAttribute = this.toggleAttribute.bind(this);
	}

	getCategoriesTree() {
		const { categoriesList } = this.props;

		let categories = [
			{
				label: "-- Show all Category --",
				value: 0,
			},
		];

		if (categoriesList && categoriesList.length > 0) {
			let grouped = GroupByParent(categoriesList);
			let tree = BuildTree(grouped);

			categories = [...categories, ...tree];
		}

		return categories;
	}

	toggleAttribute(attribute) {
		return (newValue) => {
			this.props.setAttributes({ [attribute]: newValue });
		};
	}

	render() {
		const { attributes, setAttributes, className } = this.props;

		const {
			enable_ajax,
			form_class,
			flexi_type,
			form_title,
			title_label,
			title_placeholder,
			button_label,
			category_label,
			cat,
			tag_label,
			desp_label,
			desp_placeholder,
			enable_category,
			enable_tag,
			enable_desp,
			enable_file,
			enable_bulk_file,
			file_label,
			enable_security,
			url_label,
			enable_url,
		} = attributes;

		const categories = this.getCategoriesTree();

		function toggleAttribute(attribute) {
			return (newValue) => {
				setAttributes({ [attribute]: newValue });
			};
		}

		return (
			<Fragment>
				<div className={className}>
					<InspectorControls>
						<PanelBody title={__("Form Settings", "flexi")} initialOpen={false}>
							<ToggleControl
								label="Enable Ajax Submission"
								checked={enable_ajax}
								onChange={toggleAttribute("enable_ajax")}
							/>

							<SelectControl
								label="Submission Content Type"
								value={flexi_type}
								options={[
									{
										label: "Supported Files",
										value: "image",
									},
									{
										label: "oEmbed URL",
										value: "url",
									},
								]}
								onChange={(value) => setAttributes({ flexi_type: value })}
							/>

							<TextControl
								label="Internal Form Title"
								value={form_title}
								onChange={toggleAttribute("form_title")}
							/>

							<SelectControl
								label="Form Class Style"
								value={form_class}
								options={[
									{
										label: "Stacked",
										value: "pure-form pure-form-stacked",
									},
								]}
								onChange={(value) => setAttributes({ form_class: value })}
							/>
						</PanelBody>
						<PanelBody title={__("Title Field", "flexi")} initialOpen={false}>
							<TextControl
								label="Label of Form Title"
								value={title_label}
								onChange={toggleAttribute("title_label")}
							/>
							<TextControl
								label="Title Placeholder"
								value={title_placeholder}
								onChange={toggleAttribute("title_placeholder")}
							/>
						</PanelBody>
						<PanelBody
							title={__("Description Field", "flexi")}
							initialOpen={false}
						>
							<ToggleControl
								label="Enable Description"
								checked={enable_desp}
								onChange={toggleAttribute("enable_desp")}
							/>
							{enable_desp && (
								<TextControl
									label="Description Title"
									value={desp_label}
									onChange={toggleAttribute("desp_label")}
								/>
							)}
							{enable_desp && (
								<TextControl
									label="Description Placeholder"
									value={desp_placeholder}
									onChange={toggleAttribute("desp_placeholder")}
								/>
							)}
						</PanelBody>
						<PanelBody
							title={__("Category Field", "flexi")}
							initialOpen={false}
						>
							<ToggleControl
								label="Enable Category"
								checked={enable_category}
								onChange={toggleAttribute("enable_category")}
							/>
							{enable_category && (
								<TextControl
									label="Category Title"
									value={category_label}
									onChange={toggleAttribute("category_label")}
								/>
							)}
							{enable_category && (
								<SelectControl
									label="Select Parent Category"
									value={cat}
									options={categories}
									onChange={(value) => setAttributes({ cat: Number(value) })}
								/>
							)}
						</PanelBody>
						<PanelBody title={__("Tag Field", "flexi")} initialOpen={false}>
							<ToggleControl
								label="Enable Tag"
								checked={enable_tag}
								onChange={toggleAttribute("enable_tag")}
							/>
							{tag_label && (
								<TextControl
									label="Tag Title"
									value={tag_label}
									onChange={toggleAttribute("tag_label")}
								/>
							)}
						</PanelBody>
						{flexi_type == "image" && (
							<PanelBody
								title={__("Image Upload Field", "flexi")}
								initialOpen={false}
							>
								<ToggleControl
									label="Enable Image Upload"
									checked={enable_file}
									onChange={toggleAttribute("enable_file")}
								/>
								{enable_file && (
									<ToggleControl
										label="Enable Bulk File Upload"
										checked={enable_bulk_file}
										onChange={toggleAttribute("enable_bulk_file")}
									/>
								)}
								{enable_file && (
									<TextControl
										label="Upload Title"
										value={file_label}
										onChange={toggleAttribute("file_label")}
									/>
								)}
							</PanelBody>
						)}
						{flexi_type == "url" && (
							<PanelBody
								title={__("URL Submit Field", "flexi")}
								initialOpen={false}
							>
								<ToggleControl
									label="Enable oEmbed URL"
									checked={enable_url}
									onChange={toggleAttribute("enable_url")}
								/>
								{enable_url && (
									<TextControl
										label="URL Field Title"
										value={url_label}
										onChange={toggleAttribute("url_label")}
									/>
								)}
							</PanelBody>
						)}
						<PanelBody
							title={__("Security reCaptcha Field", "flexi")}
							initialOpen={false}
						>
							<ToggleControl
								label="Enable Google reCaptcha"
								checked={enable_security}
								onChange={toggleAttribute("enable_security")}
							/>
						</PanelBody>
						<PanelBody title={__("Submit Button", "flexi")} initialOpen={false}>
							<TextControl
								label="Label of Submit Button"
								value={button_label}
								onChange={toggleAttribute("button_label")}
							/>
						</PanelBody>
					</InspectorControls>

					<ServerSideRender
						block="cgb/block-flexi-block-form"
						attributes={attributes}
					/>
				</div>
			</Fragment>
		);
	}
}

export default withSelect((select) => {
	const { getEntityRecords } = select("core");

	const categoriesListQuery = {
		per_page: 100,
	};

	return {
		categoriesList: getEntityRecords(
			"taxonomy",
			"flexi_category",
			categoriesListQuery
		),
	};
})(FlexiGalleryEdit);
