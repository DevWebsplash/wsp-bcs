Here is a brief `ReadMe.md` file describing the current functionality, file locations, and plugin structure:

```markdown
# Plugin Functionality Overview

## Purpose
This plugin synchronizes data between Airtable and WordPress. It includes error logging, testing Airtable connections, and handling records for vehicles, models, trims, and more.

## File Locations & Explanations

- **`bcs/functions/airtable/includes/air-connections.php`**  
  Defines Airtable connection details, such as credentials (`$pat`, `$baseId`), and global options or table references.

- **`bcs/functions/airtable/includes/air-admin.php`**  
  Creates admin pages and submenus for logs and data management. Includes functions for testing connections (`bcs_plugin_handle_test_button`) and clearing logs (`bcs_plugin_handle_clear_logs`).

- **`bcs/functions/airtable/includes/air-import.php`**  
  Intended for importing data from Airtable into WordPress. Can include functions to fetch records and insert or update posts.

- **`bcs/functions/airtable/includes/air-export.php`**  
  Intended for sending updated WordPress data back to Airtable. Currently stubbed or commented out.

- **`bcs/functions/airtable/includes/air-models.php`**  
  Manages model metadata (Make, Model, Trim) related to a custom post type (`vehicle`), including creating or updating WordPress posts and taxonomy terms.

- **`bcs/functions/airtable/func-airtable.php`**  
  Initializes the plugin's core functionality. Handles syncing titles from Airtable to WordPress (`sync_airtable_title_to_wp`) and includes utility functions (e.g., `get_post_id_by_meta`).

- **`bcs/functions/airtable/templates`**  
  Contains `.php` templates such as:
  - **`admin-page.php`**: A basic admin overview or future landing page.
  - **`logs-page.php`**: Displays error logs, notices, and forms to test Airtable connections and clear logs.
  - **`models-meta-page.php`**: Shows a UI for importing model metadata and viewing import status.

## Plugin Structure

```
bcs/
└── functions/
└── airtable/
├── includes/
│   ├── air-connections.php
│   ├── air-admin.php
│   ├── air-import.php
│   ├── air-export.php
│   ├── air-models.php
├── assets/
│   ├── css/
│   │   └── styles.css
│   ├── js/
│   │   └── scripts.js
├── templates/
│   ├── admin-page.php
│   ├── logs-page.php
│   ├── models-meta-page.php
├── func-airtable.php
└── ... (any additional support files)
```

This organization keeps functionalities separated, making it easier to scale the plugin for more complex imports/exports and data synchronization in the future.
```
## Installation & Setup

## Usage
- Go to 'Airtable Logs' in the WordPress admin menu to view error logs, test Airtable connections, or clear logs.
- Use 'Airtable Data' submenu for import/export operations (future expansion).
- Use 'Airtable Data MODELS Meta' to manage vehicle models and metadata.

## Collaboration
- To contribute, familiarize yourself with the existing code in the `includes` and `templates` folders.
- Submit pull requests with detailed descriptions of changes and testing steps.
- For suggestions or questions, open an issue in the repository.

## Environment Requirements
- PHP >= 7.4
- WordPress >= 5.8
- Airtable API credentials
