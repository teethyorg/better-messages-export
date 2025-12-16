# 📦 Better Messages Personal Data Export (Messages Only)

[![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/better-messages.svg?style=flat-square)](https://wordpress.org/plugins/better-messages/)
[![License](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

A lightweight and focused WordPress plugin that extends the core Personal Data Export tool to include all sent messages from the **Better Messages** plugin, ensuring GDPR and user privacy compliance.

## ✨ Overview

This plugin registers a custom data exporter with the native **Tools » Export Personal Data** utility (introduced in WordPress 4.9.6 for GDPR compliance).

If your website uses the **Better Messages** plugin for user communication, this extension ensures that when a user requests an export of their personal data, it includes a complete, machine-readable record of **all messages they have sent**.

It is designed to be a simple, 'fire-and-forget' solution for site owners who need to be fully compliant with user data export requirements.

## 🤝 Compatibility & Testing

**This plugin has been specifically developed and tested only within an environment using the following plugins:**

* **Better Messages** (Core functionality dependency)
* **Fluent Community** (The common platform/context for Better Messages usage)

While it may work with other community/membership setups that utilize Better Messages, its functionality and stability are guaranteed only in combination with the **Fluent Community** plugin. 

## 🔑 Key Features

* **Seamless Integration:** Hooks directly into the standard WordPress Personal Data Export process.
* **Targeted Export:** Specifically targets the `bm_message_messages` and `bm_message_meta` database tables.
* **Messages & Meta:** Exports both the **message content** (`message`, `date_sent`, `thread_id`) and all associated **message metadata** (`meta_key`, `meta_value`).
* **Pagination:** Implements pagination logic (200 items per batch) to handle large volumes of data without timeouts, ensuring reliable export completion.
* **Privacy Focused:** Only exports data where the user is the **sender**, aligning with user-requested data portability.

## ⚙️ Installation

### Method 1: Upload via WordPress Dashboard

1.  **Download:** Download the latest release ZIP file of this repository.
2.  **Upload:** In your WordPress dashboard, navigate to **Plugins » Add New » Upload Plugin** and upload the ZIP file.
3.  **Activate:** Click **Activate Plugin**.

### Method 2: Manual (via FTP/SFTP)

1.  **Extract:** Extract the plugin ZIP file.
2.  **Upload:** Upload the extracted folder to the `/wp-content/plugins/` directory.
3.  **Activate:** Go to **Plugins** in your WordPress dashboard and activate the **Better Messages Personal Data Export (Messages Only)** plugin.

## 💻 Usage

Once the plugin is installed and activated:

1.  Navigate to **Tools » Export Personal Data** in your WordPress admin.
2.  Enter the **user's email address** to generate the request.
3.  When the export file is generated, the resulting ZIP will contain a JSON file with the user's data. This file will now include two new data groups:
    * **Better Messages – Messages**
    * **Better Messages – Meta**

## ⚠️ Requirements

* **WordPress:** Version 4.9.6 or higher.
* **Better Messages Plugin:** Must be installed and active on your site.

## 🤝 Contribution

Contributions are welcome! If you find a bug or have a suggestion, please feel free to open an issue or submit a pull request on GitHub.

## 📜 License

This plugin is licensed under the GPL v2 or later.

---
**Plugin Name:** Better Messages Personal Data Export (Messages Only)  
**Author:** teethy  
**Author URI:** https://teethy.org
