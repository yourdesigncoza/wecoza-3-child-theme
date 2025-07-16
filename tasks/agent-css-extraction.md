# Agent-Specific CSS Extraction

## Investigation Results from Subtask 1.4

### CSS Files Analyzed

1. **`/includes/css/ydcoza-styles.css`** - Main theme styles
2. **`/includes/css/ydcoza-theme.css`** - Theme base styles
3. **No dedicated agent CSS files found** in `/assets/agents/` directory

### Agent-Specific CSS Selectors Found

#### In ydcoza-styles.css

Only **2 agent-specific CSS rules** found:

```css
/* Line 2132 - Light theme */
.note-category-agent-absent {
    background-color: #dbeafe;
    color: #1e40af;
    border-color: #93c5fd;
}

/* Line 2211 - Dark theme variant */
html[data-bs-theme="dark"] .note-category-agent-absent {
    background-color: #1e3a8a;
    color: #93c5fd;
    border-color: #3730a3;
}
```

**Purpose**: These styles are for "Agent Absent" category badges/notes, likely used in the learner or scheduling system.

### CSS Classes Used by Agent Components

#### Agent Capture Form (`agents-capture-shortcode.php`)

The form uses standard Bootstrap 5 classes plus these theme classes:
- `ydcoza-compact-form` - Custom form styling
- `ydcoza-notification` - Alert/notification styling
- `ydcoza-auto-close` - Auto-closing notifications
- `needs-validation` - Bootstrap validation

No agent-specific custom classes found.

#### Agent Display Table (`agents-display-shortcode.php`)

Uses primarily Bootstrap classes:
- `bootstrap-table bootstrap5` - Table framework
- `borderless-table` - Table styling
- `bg-discovery-subtle` - Theme color utilities
- `bg-warning-subtle` - Theme color utilities

No agent-specific custom classes found.

### Inline Styles Found

#### In agents-display-shortcode.php

```html
<!-- Line 45 -->
<div class="fixed-table-container" style="padding-bottom: 0px;">

<!-- Line 46 -->
<div class="fixed-table-header" style="display: none;">

<!-- Line 50 -->
<div class="fixed-table-loading..." style="top: 1px;">

<!-- Line 492 -->
<div class="accordion..." style="margin:0 -11px">

<!-- Line 542 -->
<button class="accordion-button..." style="background-color: #6e5dc6; color: white">
```

### CSS Dependencies

Agent components rely on:
1. **Bootstrap 5** - Primary UI framework
2. **Bootstrap Icons** - Icon library
3. **Select2** - Enhanced select dropdowns
4. **Theme utilities** - Color and spacing classes

### Migration Requirements

#### Minimal CSS to Extract

```css
/* Agent-specific styles to migrate to plugin */
.note-category-agent-absent {
    background-color: #dbeafe;
    color: #1e40af;
    border-color: #93c5fd;
}

html[data-bs-theme="dark"] .note-category-agent-absent {
    background-color: #1e3a8a;
    color: #93c5fd;
    border-color: #3730a3;
}
```

#### Inline Styles to Move

Consider moving these inline styles to CSS classes:
```css
/* Fixed table adjustments */
.agents-fixed-table-container {
    padding-bottom: 0px;
}

.agents-fixed-table-header {
    display: none;
}

.agents-fixed-table-loading {
    top: 1px;
}

/* Accordion adjustments */
.agents-accordion-flush {
    margin: 0 -11px;
}

/* Update button styling */
.agents-update-button {
    background-color: #6e5dc6;
    color: white;
}
```

### Recommendations

1. **Create `agents-extracted.css`** with only the 2 agent-specific rules
2. **Remove inline styles** and create proper CSS classes
3. **Rely on theme/parent styles** for Bootstrap and utilities
4. **Document CSS dependencies** for theme compatibility
5. **Consider namespacing** all agent classes with `.wecoza-agents-` prefix

### CSS Migration Impact

- **Minimal extraction needed** - Only 2 CSS rules
- **No complex styling** to migrate
- **Heavy Bootstrap dependency** - Ensure Bootstrap 5 is available
- **Theme color utilities used** - Document required theme classes