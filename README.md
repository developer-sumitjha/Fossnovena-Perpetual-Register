## Fossnovena Perpetual Register

**Fossnovena Perpetual Register** is a WordPress plugin that manages and displays a “Perpetual Register” – a list of names (with life statistics) that can be imported from CSV and browsed on the front‑end.

The plugin provides:

- **Custom database table** to store register entries.
- **CSV import tool** (append or replace) from the WordPress admin.
- **Admin listing screen** with pagination and inline edit/delete via AJAX.
- **Frontend shortcode** with A–Z letter filtering and live result count.
- **Optional database reset on deactivation** (via Settings).

---

## Requirements

- **WordPress** 5.0 or higher  
- **PHP** 7.4 or higher

---

## Installation

- **Upload via Admin**
  - Download or place the plugin folder `fossnovena-perpetual-register` in your project.
  - In the WordPress dashboard go to **Plugins → Add New → Upload Plugin**.
  - Upload the zipped plugin (if applicable) and click **Install Now**.
  - Click **Activate**.

- **Manual (FTP / file system)**
  - Copy the `fossnovena-perpetual-register` directory into `wp-content/plugins/`.
  - In the dashboard, go to **Plugins → Installed Plugins** and click **Activate** for **Fossnovena Perpetual Register**.

When activated, the plugin:

- Creates the required database table via `FNPR_Register_Activator::activate()`.
- Registers admin menus and pages.
- Registers AJAX handlers and the public shortcode.

---

## Admin Interface

After activation you will see a **Perpetual Register** menu item in the WordPress admin.

- **Main List Page**
  - Path: **Perpetual Register → Perpetual Register**
  - Displays all entries from the `perpetual_register` table.
  - Columns: **Entry ID**, **Entry**, **Life Stats**, **Sort**, **Actions**.
  - Supports:
    - Pagination and “per page” selector (20, 50, 100, 200, 500).
    - Edit/Delete actions using AJAX (`FNPR_Ajax_Actions`).

- **Import Data**
  - Path: **Perpetual Register → Import Data**
  - Upload a CSV file and choose import type:
    - **Append New Data** – keep existing rows and append new rows.
    - **Replace Existing Data** – truncate the table and import only the new rows.
  - CSV is processed by `FNPR_CSV_Importer`.

- **Settings**
  - Path: **Perpetual Register → Settings**
  - Option: **Reset Database on Plugin Deactivation** (`fnpr_reset_database`).
    - When enabled, the plugin will drop/clear the Perpetual Register table on deactivation (handled by `FNPR_Register_Deactivator`).

---

## CSV Format

The CSV importer expects a header row (which is skipped) and then one row per entry with four columns:

1. **entry_id** – internal ID/string for the entry.  
2. **entry** – display name (e.g. person’s name).  
3. **life_stats** – text describing life statistics; the importer normalizes certain dash characters.  
4. **sort** – numeric or textual value used for ordering in the list.

Example:

```csv
entry_id,entry,life_stats,sort
1,John Smith,1940–2020,1
2,Jane Doe,1950–2019,2
```

Empty rows are ignored during import. If **Replace Existing Data** is selected, the table is truncated before new rows are inserted.

---

## Frontend Usage

- **Shortcode**

Insert the following shortcode into any page or post where you want the Perpetual Register to appear:

```text
[fnpr_register_list]
```

This renders:

- A left‑hand title/description section.
- An A–Z filter bar to filter entries by the first letter of the `entry` field.
- A results count that updates when filters are applied.
- A responsive grid list of entries (`entry` + `life_stats`).

The markup, JavaScript, and inline styles are defined in `public/class-fnpr-shortcode.php`. Additional public styles/scripts are enqueued via `FNPR_Public_Enqueue`.

---

## Uninstall / Deactivation

On deactivation (`register_deactivation_hook` in `perpetual-register.php`):

- `FNPR_Register_Deactivator::deactivate()` runs.
- If **Reset Database on Plugin Deactivation** is enabled, the Perpetual Register database table is reset.

