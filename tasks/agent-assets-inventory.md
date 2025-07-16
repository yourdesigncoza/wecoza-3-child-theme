# Agent Assets Inventory

## Investigation Results from Subtask 1.7

### Asset Files Found

#### CSS Files
1. **`agents-extracted.css`**
   - Location: `/assets/agents/agents-extracted.css`
   - Size: 41 lines
   - Created during subtask 1.4
   - Contains extracted agent-specific styles

#### JavaScript Files
1. **`agents-app.js`**
   - Location: `/assets/agents/js/agents-app.js`
   - Size: 239 lines
   - No minified version exists

#### Images
**No image files found** in the agents directory structure.

### Icon Usage

#### Bootstrap Icons (via CDN)
Used in `agents-display-shortcode.php`:
- `bi-arrow-clockwise` - Refresh button (line 21)
- `bi-list-ul` - Column visibility toggle (line 25)

#### Bootstrap Components
- `spinner-border` - Loading spinner (line 10)
- No FontAwesome icons used (despite being available)

### External Assets

#### Loaded via CDN (from parent theme)
1. **Bootstrap Icons 1.11.3**
   - URL: `https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css`

2. **Select2 4.1.0-rc.0**
   - CSS: `https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css`
   - JS: `https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js`

### File Upload Handling

The agent capture form includes file upload fields:
- `signed_agreement_file` - For agreement documents
- `criminal_record_file` - For criminal record certificates

**Note**: No actual file handling or storage implementation found.

### Missing Assets

1. **No logo or branding images**
2. **No placeholder images**
3. **No custom icons**
4. **No PDF or document templates**
5. **No loading animations** (uses Bootstrap spinner)

### Asset Dependencies

All visual assets depend on:
1. **Bootstrap 5** - For UI components
2. **Bootstrap Icons** - For iconography
3. **Theme styles** - For colors and typography

### Migration Requirements

#### Assets to Include in Plugin
1. **CSS**:
   - Copy `agents-extracted.css` to plugin
   - Create minified version

2. **JavaScript**:
   - Copy `agents-app.js` to plugin
   - Create minified version

3. **Icons**:
   - Document Bootstrap Icons dependency
   - No custom icons to migrate

#### Asset Loading Strategy
1. Only load assets when shortcodes are present
2. Maintain CDN dependencies from parent theme
3. Add local fallbacks for critical assets

### Recommendations

1. **Create minified versions** of CSS and JS files
2. **Add loading placeholder** for better UX
3. **Include default avatar** for agents without photos
4. **Add file type icons** for uploaded documents
5. **Consider bundling Select2** to avoid CDN dependency
6. **Add print stylesheet** for agent reports

### File Structure for Plugin Assets
```
wecoza-agents-plugin/
└── assets/
    ├── css/
    │   ├── agents-extracted.css
    │   └── agents-extracted.min.css
    ├── js/
    │   ├── agents-app.js
    │   └── agents-app.min.js
    └── images/
        └── (empty - no images to migrate)
```