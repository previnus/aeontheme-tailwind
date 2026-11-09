# Aeon Theme Tailwind

Aeon Theme Tailwind is a classic WordPress theme for business websites and blogs. It includes a responsive header and footer, a filterable blog archive, and 40 configurable page layouts with ACF PRO.

[Download the latest WordPress theme ZIP](https://github.com/previnus/aeontheme-tailwind/releases/latest/download/aeontheme-tailwind.zip)

## 1. Install the theme

The theme requires WordPress 6.6 or later and PHP 7.4 or later. The release ZIP includes the compiled stylesheet and is ready to install directly in WordPress. Standard pages, posts, and archives work with WordPress alone. Add ACF PRO to use **Page Sections** and **Aeon Theme Options**.

1. Download `aeontheme-tailwind.zip` from the link above.
2. Sign in to WordPress as an administrator. Go to **Appearance → Themes → Add New → Upload Theme**.
3. Choose the ZIP, click **Install Now**, then **Activate**.
4. Open the front end and check that **Aeon Theme Tailwind** is active.

For a manual install, extract the ZIP and copy the `aeontheme-tailwind/` folder to `wp-content/themes/`. Activate it under **Appearance → Themes**. [WordPress theme installation guide](https://wordpress.org/documentation/article/work-with-themes/)

### Enable the page builder

Download the ACF PRO ZIP from your ACF account. In WordPress, go to **Plugins → Add New Plugin → Upload Plugin**, install the ZIP, and activate the plugin. Manage your ACF license under **ACF → Updates**. The theme registers its field groups and options page automatically. [ACF PRO installation and activation](https://www.advancedcustomfields.com/resources/how-to-activate/)

## 2. Configure your site

### Site identity and menus

1. Go to **Settings → General** and set your site title, tagline, and Site Icon.
2. Go to **Appearance → Customize → Site Identity** to upload a WordPress logo. The theme uses it as a fallback when a theme-specific logo is missing, then falls back to the site title.
3. In **Appearance → Menus**, create menus and assign them under **Manage Locations**.
   - **Primary Menu** appears in the main header. **Secondary Menu** adds another desktop navigation row.
   - **Mobile Menu** controls the mobile drawer. Leave it unassigned to reuse the primary and secondary menus there.
   - **Footer Menu** and **Footer Resources Menu** add separate link columns to the footer.

To set up a mega menu, assign a nested menu to **Mega Menu** or **Additional Mega Menu**. Use top-level items as group headings and nest the links under them. In **Appearance → Menus**, enable **CSS Classes** from **Screen Options**, then add `menu-item-has-mega` to the top-level item in **Secondary Menu** that should open the panel.

### Aeon Theme Options

With ACF PRO active, open **Aeon Theme Options** in the dashboard.

| Tab | What you can configure |
| --- | --- |
| **Branding** | Upload a logo for dark hero backgrounds, a version for light headers, and optional mobile and footer logos. Set the default image for social previews. |
| **Header & Footer** | Set the header button label and destination, phone number, email, address, footer text, and social or legal links. Add global location and category directories if needed. |
| **Forms** | Add one shortcode per field for the quote, financing, product, or newsletter dialog. |
| **Blog** | Set the archive URL, author details, related-posts heading, and call to action shown on posts and the blog archive. |

To show the header contact button, configure the quote form shortcode or provide a **Header CTA URL** such as `/contact/`. When both are available, the button opens the form. Configure and test submission delivery in the form plugin that supplies the shortcode. The **Contact Section** and **Contact Form and Details** page layouts also accept their own shortcode for an embedded form.

## 3. Build pages and publish posts

### Build a homepage or landing page

1. Go to **Pages → Add New** and give the page a title.
2. Find **Page Sections** below the block editor, in the **Meta Boxes** area if it is collapsed. Click **Add Section** and choose a layout.
3. Start with **Hero** or **Page Header**, then add sections such as **Cards Grid**, **FAQ**, and **Call to Action Band**. Fill in the text, choose images from the Media Library, and add destinations to any buttons you want to show.
4. Drag sections into the order you want. Preview the page on desktop and mobile, then publish it.
5. To use the page as your homepage, go to **Settings → Reading**, choose **A static page**, and select it under **Homepage**. [WordPress static homepage guide](https://wordpress.org/documentation/article/create-a-static-front-page/)

Pages with builder sections display those sections. For a regular WordPress page, leave **Page Sections** empty and write your content in the block editor.

### Set up the filterable blog

1. Create a page called **Blog** and select **Blog Archive** under **Template** in the page settings sidebar.
2. Publish the page and keep it as a regular page so WordPress loads the **Blog Archive** template. You can add the page to a navigation menu.
3. When the page uses the slug `blog`, the theme can find it automatically. With ACF PRO active, you can set **Blog URL** in **Aeon Theme Options → Blog** to use a different permalink.
4. Create articles under **Posts**. Add featured images, excerpts, and categories. The archive uses your categories and subcategories for its filters.

## 4. Edit CSS in WordPress

Go to **Appearance → Customize → Additional CSS**. Paste standard CSS, preview the changes, and click **Publish**. The following example changes the theme’s shared accent colors.

```css
:root {
  --aeon-accent: #0f766e;
  --aeon-accent-strong: #115e59;
  --aeon-accent-soft: #99f6e4;
}
```

WordPress stores these overrides separately from the theme files. Keep the same folder name when updating the theme. When switching from a different theme folder, copy your Additional CSS from the old Customizer and paste it into the new one. [WordPress Customizer guide](https://wordpress.org/documentation/article/customizer/#additional-css)

## Troubleshooting

| If you see this | Check this |
| --- | --- |
| WordPress says the stylesheet is missing | Upload the `aeontheme-tailwind.zip` release asset. For manual installs, check that `style.css` is directly inside `wp-content/themes/aeontheme-tailwind/`. |
| **Page Sections** or **Aeon Theme Options** is missing | Check that ACF PRO is active. Edit a regular page to see **Page Sections**. Sign in as an administrator to see **Aeon Theme Options**. |
| A contact or newsletter button is missing | Check that the associated shortcode comes from an active plugin and renders a form. For contact buttons, provide a **Header CTA URL** as a fallback. |
| The blog is missing its category filters | Check that the page uses **Blog Archive**, has posts assigned to categories, and is a regular page in **Settings → Reading**. |
| Your CSS changes are missing | Check that you clicked **Publish** in Additional CSS for the active theme, then clear any page or CDN cache. |

## Update or move an existing Aeon site

Back up the site and test the new ZIP on a staging copy before switching. Keep existing ACF field groups in place. Aeon recognizes the existing `page_builder` field, page template filenames, and global settings storage. After switching, review menu locations, logos, form shortcodes, and links. If the theme folder name changed, transfer your Additional CSS from the previous theme.

## Rebuild Tailwind CSS for development

With Node.js and npm installed, run these commands from the repository root.

```sh
npm ci
npm run build
```

Edit `src/tailwind.css` for base styles or use prefixed Tailwind classes such as `tw:relative` in templates. Use `npm run watch` to rebuild as you work. The compiled file is `aeontheme-tailwind/css/main.css`. For dashboard overrides, use standard CSS in the Customizer. Tailwind directives such as `@apply` belong in the source stylesheet.

## License

[GNU General Public License v2 or later](aeontheme-tailwind/LICENSE.txt)
