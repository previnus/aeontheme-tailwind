# Aeon Theme Tailwind

Aeon Theme Tailwind is a classic WordPress theme with 40 configurable page sections. The builder requires ACF PRO. Standard WordPress pages, posts, and archives also work with the block editor.

## Clean install

Use a fresh WordPress installation with WordPress 6.6 or later and PHP 7.4 or later. ACF PRO enables the page builder and the theme options.

1. Download the installable `aeontheme-tailwind.zip` from [GitHub Releases](https://github.com/previnus/aeontheme-tailwind/releases).
2. In WordPress, open **Appearance → Themes → Add New → Upload Theme**, upload the ZIP, and activate **Aeon Theme Tailwind**. With filesystem access, you can extract the ZIP and copy the `aeontheme-tailwind/` folder to `wp-content/themes/`.
3. Install and activate ACF PRO to use the builder. Aeon registers its field groups automatically on a clean site.

## Build your first page

1. Create a page and choose **Page Sections → Add Section**. Open the editor’s **Meta Boxes** pane if the builder is collapsed. Drag sections to reorder them. Pages without builder sections use the standard editor content.
2. To make the page your homepage, publish it and select it under **Settings → Reading**.
3. Set the site title and Site Icon under **Settings → General**. Assign menus under **Appearance → Menus**. For a mega menu, assign a nested menu to **Mega Menu** or **Additional Mega Menu** and add the `menu-item-has-mega` CSS class to a top-level item in **Secondary Menu**. Assign a **Mobile Menu** or use the primary and secondary menus as the mobile fallback.

## Configure the theme

Open **Aeon Theme Options** in the WordPress dashboard.

- **Branding** sets logo variants and the default social preview image. Aeon falls back to the WordPress logo or site title.
- **Header & Footer** sets the main button, contact details, and footer links. These values may be displayed publicly.
- **Forms** sets optional shortcodes for the quote, product, financing, and newsletter dialogs.
- **Blog** sets the archive link, author display, and post call to action. For a filterable archive, assign **Blog Archive** to a regular page and enter its URL.

Form fields take one shortcode from an active plugin. Configure recipients, delivery, and credentials in that plugin. The contact buttons use the configured form, then the header CTA URL if there is no form. A CTA without either destination is hidden.

## Edit CSS in WordPress

Open **Appearance → Customize → Additional CSS**. Enter standard CSS, check the live preview, and click **Publish**. You can override individual components or change shared design variables. For example:

```css
:root {
  --aeon-accent: #0f766e;
  --aeon-accent-strong: #115e59;
  --aeon-accent-soft: #99f6e4;
}
```

WordPress saves Additional CSS and theme settings under the installed folder name. If the existing site uses `aeon-theme` or another folder name, copy its Additional CSS before switching to `aeontheme-tailwind`, then paste it into the new theme's Customizer.

## Build Tailwind CSS

The installable theme ships with compiled CSS and runs on WordPress without Node.js. To change the base design, edit `src/tailwind.css` or use prefixed Tailwind utilities such as `tw:relative` in a theme template. From the repository root, run `npm ci` followed by `npm run build`. Use `npm run watch` while developing. Deploy the rebuilt `aeontheme-tailwind/css/main.css` with the theme.

Tailwind compiles utilities and directives such as `@apply` during the build. Use regular CSS for overrides in the WordPress Customizer.

## Move an existing site to Aeon

Keep the existing ACF field groups when moving a site. Aeon keeps the page-builder field and layout names, the page-template filenames, and the global settings storage. When it finds an existing flexible-content field named `page_builder`, it uses that definition. It adds site settings fields that are missing from the existing settings group. The tabs organize Aeon’s bundled fields. Existing ACF groups keep their original layout.

After switching themes, review the menu assignments, logos, form settings, custom CSS, and saved links. The new theme uses `aeon-` CSS names and image sizes. Existing content and settings in the WordPress database carry over with the site. Use a fresh installation when starting a site with blank settings.
