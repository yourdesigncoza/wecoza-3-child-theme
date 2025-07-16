# JavaScript Dependencies Documentation

## Investigation Results from Subtask 1.6

### Core Dependencies

#### 1. **jQuery**
- **Version**: Not specified (WordPress bundled version)
- **Usage**: Primary JavaScript framework
- **Used for**: DOM manipulation, event handling, AJAX (prepared but unused)
- **Enqueued**: WordPress core

#### 2. **Bootstrap 5**
- **Version**: 5.1.3
- **Components used**:
  - Forms validation (`needs-validation` class)
  - Modal system (agent details modal)
  - Collapse/Accordion (agent information tabs)
  - Dropdown (column visibility toggle)
  - Table styling
  - Button components
  - Alert/notification system
- **CSS**: Loaded by parent theme
- **JS**: Loaded by parent theme (comment confirms: "bootstrap Loaded in Parent theme")

#### 3. **Select2**
- **Version**: 4.1.0-rc.0
- **CDN**: `https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/`
- **Usage**: Enhanced multi-select dropdowns for "Preferred Working Areas"
- **Configuration**:
  ```javascript
  {
      width: '100%',
      placeholder: $(this).data('placeholder'),
      closeOnSelect: true,
      allowClear: true
  }
  ```

#### 4. **Bootstrap Icons**
- **Version**: 1.11.3
- **CDN**: `https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/`
- **Icons used**:
  - `bi-arrow-clockwise` (refresh button)
  - `bi-list-ul` (column visibility)

### Additional Libraries (Loaded but not used by agents)

1. **Chart.js**
   - Loaded globally but not used in agent functionality
   
2. **Popper.js**
   - Version: 2.11.8
   - Dependency for Bootstrap dropdowns/tooltips

### JavaScript Files

#### Agent-Specific JavaScript
1. **`agents-app.js`**
   - Location: `/assets/agents/js/agents-app.js`
   - Size: 239 lines
   - Dependencies: jQuery, Bootstrap 5, Select2

#### Localized Script Data
From `agents-functions.php`:
```javascript
agents_nonce = {
    ajax_url: admin_url('admin-ajax.php'),
    nonce: wp_create_nonce('agents_nonce'),
    uploads_url: wp_upload_dir()['baseurl'],
    is_admin: current_user_can('manage_options')
}
```

From `functions.php` (globally available):
```javascript
wecoza_ajax = {
    ajax_url: admin_url('admin-ajax.php')
}
```

### JavaScript Functionality Breakdown

#### 1. Form Validation
- **Bootstrap 5 validation**: Client-side form validation
- **Custom validation**:
  - SA ID number checksum algorithm
  - Passport format validation
- **Real-time feedback**: Validation on input events

#### 2. Dynamic UI Elements
- **ID Type Toggle**: Show/hide SA ID or Passport fields
- **Signed Agreement Toggle**: Show/hide date and file upload fields
- **Loader Animation**: 2-second loader on page load

#### 3. Select2 Integration
- Applied to 3 preferred working area selects
- Allows clearing selections
- Custom placeholder support

### Browser Compatibility

Based on library versions:
- **Minimum browsers**:
  - Chrome 60+
  - Firefox 60+
  - Safari 10.1+
  - Edge 79+
- **Internet Explorer**: Not supported (Bootstrap 5 dropped IE support)

### Load Order

1. jQuery (WordPress core)
2. Popper.js
3. Bootstrap 5 JS (parent theme)
4. Select2
5. agents-app.js (depends on all above)

### Migration Considerations

1. **Dependency on parent theme**: Bootstrap 5 must be available
2. **jQuery required**: WordPress version sufficient
3. **Select2 version**: Consider updating to stable 4.1.0
4. **No build process**: All libraries loaded from CDN
5. **No minification**: agents-app.js not minified

### Recommendations for Plugin

1. **Document parent theme dependency** for Bootstrap 5
2. **Bundle Select2** with plugin to avoid CDN dependency
3. **Create minified version** of agents-app.js
4. **Add version checking** for required libraries
5. **Consider bundling** all agent JS into single file
6. **Add fallback loading** if parent theme changes