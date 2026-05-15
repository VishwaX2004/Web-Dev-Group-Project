<div
  class="export-wrapper"
  style="
    width: 1440px;
    min-height: 812px;
    position: relative;
    font-family: var(--font-family-body);
    background-color: var(--background);
  "
>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@100;200;300;400;500;600;700;800;900&family=Geist:wght@100;200;300;400;500;600;700;800;900&family=IBM+Plex+Mono:wght@100;200;300;400;500;600;700&family=IBM+Plex+Sans:wght@100;200;300;400;500;600;700&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:wght@200;300;400;500;600;700;800;900&family=PT+Serif:wght@400;700&family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&family=Shantell+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  />
  <html>
    <head>
      <style>
        /*! tailwindcss v4.2.4 | MIT License | https://tailwindcss.com */
        @layer properties;
        @layer theme, base, components, utilities;
        @layer theme {
          :root,
          :root {
            --font-sans:
              ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji",
              "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            --font-mono:
              ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas,
              "Liberation Mono", "Courier New", monospace;
            --spacing: 0.25rem;
            --container-md: 28rem;
            --text-xs: 12px;
            --text-xs--line-height: calc(1 / 0.75);
            --text-sm: 14px;
            --text-sm--line-height: calc(1.25 / 0.875);
            --text-lg: 18px;
            --text-lg--line-height: calc(1.75 / 1.125);
            --text-2xl: 24px;
            --text-2xl--line-height: calc(2 / 1.5);
            --font-weight-normal: 400;
            --font-weight-medium: 500;
            --font-weight-semibold: 600;
            --font-weight-bold: 700;
            --tracking-wider: 0.05em;
            --radius-md: 8px;
            --radius-lg: 12px;
            --blur-sm: 8px;
            --default-transition-duration: 150ms;
            --default-transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            --default-font-family: var(--font-sans);
            --default-mono-font-family: var(--font-mono);
            --color-background: #ffffff;
            --color-foreground: #000000;
            --color-surface: #ffffff;
            --color-sidebar: #ffffff;
            --color-sidebar-text: #6b7280;
            --color-sidebar-active: #f3f4f6;
            --color-sidebar-active-text: #4169e1;
            --color-sidebar-border: #e5e7eb;
            --color-border: #e5e7eb;
            --color-input: #f3f4f6;
            --color-primary: #4169e1;
            --color-primary-foreground: #ffffff;
            --color-primary-hover: #3154b5;
            --color-secondary: #f3f4f6;
            --color-secondary-foreground: #000000;
            --color-muted: #f3f4f6;
            --color-muted-foreground: #6b7280;
            --color-accent: #000000;
            --color-accent-foreground: #ffffff;
            --color-destructive: #ef4444;
            --color-destructive-foreground: #ffffff;
            --color-warning: #f59e0b;
            --color-warning-light: #fef3c7;
            --color-warning-text: #b45309;
            --color-success: #10b981;
            --color-success-light: #d1fae5;
            --color-success-text: #047857;
            --font-body: Inter;
            --font-headings: Inter;
          }
        }
        @layer base {
          *,
          ::after,
          ::before,
          ::backdrop,
          ::file-selector-button {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            border: 0 solid;
          }
          html,
          :root {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            tab-size: 4;
            font-family: var(
              --default-font-family,
              ui-sans-serif,
              system-ui,
              sans-serif,
              "Apple Color Emoji",
              "Segoe UI Emoji",
              "Segoe UI Symbol",
              "Noto Color Emoji"
            );
            font-feature-settings: var(--default-font-feature-settings, normal);
            font-variation-settings: var(
              --default-font-variation-settings,
              normal
            );
            -webkit-tap-highlight-color: transparent;
          }
          hr {
            height: 0;
            color: inherit;
            border-top-width: 1px;
          }
          abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted;
          }
          h1,
          h2,
          h3,
          h4,
          h5,
          h6 {
            font-size: inherit;
            font-weight: inherit;
          }
          a {
            color: inherit;
            -webkit-text-decoration: inherit;
            text-decoration: inherit;
          }
          b,
          strong {
            font-weight: bolder;
          }
          code,
          kbd,
          samp,
          pre {
            font-family: var(
              --default-mono-font-family,
              ui-monospace,
              SFMono-Regular,
              Menlo,
              Monaco,
              Consolas,
              "Liberation Mono",
              "Courier New",
              monospace
            );
            font-feature-settings: var(
              --default-mono-font-feature-settings,
              normal
            );
            font-variation-settings: var(
              --default-mono-font-variation-settings,
              normal
            );
            font-size: 1em;
          }
          small {
            font-size: 80%;
          }
          sub,
          sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline;
          }
          sub {
            bottom: -0.25em;
          }
          sup {
            top: -0.5em;
          }
          table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse;
          }
          :-moz-focusring {
            outline: auto;
          }
          progress {
            vertical-align: baseline;
          }
          summary {
            display: list-item;
          }
          ol,
          ul,
          menu {
            list-style: none;
          }
          img,
          svg,
          video,
          canvas,
          audio,
          iframe,
          embed,
          object {
            display: block;
            vertical-align: middle;
          }
          img,
          video {
            max-width: 100%;
            height: auto;
          }
          button,
          input,
          select,
          optgroup,
          textarea,
          ::file-selector-button {
            font: inherit;
            font-feature-settings: inherit;
            font-variation-settings: inherit;
            letter-spacing: inherit;
            color: inherit;
            border-radius: 0;
            background-color: transparent;
            opacity: 1;
          }
          :where(select:is([multiple], [size])) optgroup {
            font-weight: bolder;
          }
          :where(select:is([multiple], [size])) optgroup option {
            padding-inline-start: 20px;
          }
          ::file-selector-button {
            margin-inline-end: 4px;
          }
          ::placeholder {
            opacity: 1;
          }
          @supports (not (-webkit-appearance: -apple-pay-button)) or
            (contain-intrinsic-size: 1px) {
            ::placeholder {
              color: currentcolor;
              @supports (color: color-mix(in lab, red, red)) {
                color: color-mix(in oklab, currentcolor 50%, transparent);
              }
            }
          }
          textarea {
            resize: vertical;
          }
          ::-webkit-search-decoration {
            -webkit-appearance: none;
          }
          ::-webkit-date-and-time-value {
            min-height: 1lh;
            text-align: inherit;
          }
          ::-webkit-datetime-edit {
            display: inline-flex;
          }
          ::-webkit-datetime-edit-fields-wrapper {
            padding: 0;
          }
          ::-webkit-datetime-edit,
          ::-webkit-datetime-edit-year-field,
          ::-webkit-datetime-edit-month-field,
          ::-webkit-datetime-edit-day-field,
          ::-webkit-datetime-edit-hour-field,
          ::-webkit-datetime-edit-minute-field,
          ::-webkit-datetime-edit-second-field,
          ::-webkit-datetime-edit-millisecond-field,
          ::-webkit-datetime-edit-meridiem-field {
            padding-block: 0;
          }
          ::-webkit-calendar-picker-indicator {
            line-height: 1;
          }
          :-moz-ui-invalid {
            box-shadow: none;
          }
          button,
          input:where([type="button"], [type="reset"], [type="submit"]),
          ::file-selector-button {
            appearance: button;
          }
          ::-webkit-inner-spin-button,
          ::-webkit-outer-spin-button {
            height: auto;
          }
          [hidden]:where(:not([hidden="until-found"])) {
            display: none !important;
          }
        }
        @layer utilities {
          .absolute {
            position: absolute;
          }
          .fixed {
            position: fixed;
          }
          .relative {
            position: relative;
          }
          .inset-0 {
            inset: calc(var(--spacing) * 0);
          }
          .-top-1 {
            top: calc(var(--spacing) * -1);
          }
          .top-1\/2 {
            top: calc(1 / 2 * 100%);
          }
          .-right-1 {
            right: calc(var(--spacing) * -1);
          }
          .left-3 {
            left: calc(var(--spacing) * 3);
          }
          .z-50 {
            z-index: 50;
          }
          .mt-0\.5 {
            margin-top: calc(var(--spacing) * 0.5);
          }
          .mt-1 {
            margin-top: calc(var(--spacing) * 1);
          }
          .mt-2 {
            margin-top: calc(var(--spacing) * 2);
          }
          .mt-auto {
            margin-top: auto;
          }
          .mr-1\.5 {
            margin-right: calc(var(--spacing) * 1.5);
          }
          .mr-2 {
            margin-right: calc(var(--spacing) * 2);
          }
          .block {
            display: block;
          }
          .flex {
            display: flex;
          }
          .grid {
            display: grid;
          }
          .hidden {
            display: none;
          }
          .inline-flex {
            display: inline-flex;
          }
          .size-\[12px\] {
            width: 12px;
            height: 12px;
          }
          .size-\[14px\] {
            width: 14px;
            height: 14px;
          }
          .size-\[16px\] {
            width: 16px;
            height: 16px;
          }
          .size-\[18px\] {
            width: 18px;
            height: 18px;
          }
          .size-\[20px\] {
            width: 20px;
            height: 20px;
          }
          .size-\[24px\] {
            width: 24px;
            height: 24px;
          }
          .h-1\.5 {
            height: calc(var(--spacing) * 1.5);
          }
          .h-4 {
            height: calc(var(--spacing) * 4);
          }
          .h-8 {
            height: calc(var(--spacing) * 8);
          }
          .h-10 {
            height: calc(var(--spacing) * 10);
          }
          .h-16 {
            height: calc(var(--spacing) * 16);
          }
          .h-fit {
            height: fit-content;
          }
          .h-full {
            height: 100%;
          }
          .h-screen {
            height: 100vh;
          }
          .w-1\.5 {
            width: calc(var(--spacing) * 1.5);
          }
          .w-4 {
            width: calc(var(--spacing) * 4);
          }
          .w-8 {
            width: calc(var(--spacing) * 8);
          }
          .w-64 {
            width: calc(var(--spacing) * 64);
          }
          .w-full {
            width: 100%;
          }
          .max-w-md {
            max-width: var(--container-md);
          }
          .min-w-0 {
            min-width: calc(var(--spacing) * 0);
          }
          .min-w-\[600px\] {
            min-width: 600px;
          }
          .min-w-\[800px\] {
            min-width: 800px;
          }
          .flex-1 {
            flex: 1;
          }
          .flex-shrink-0 {
            flex-shrink: 0;
          }
          .shrink-0 {
            flex-shrink: 0;
          }
          .border-collapse {
            border-collapse: collapse;
          }
          .-translate-y-1\/2 {
            --tw-translate-y: calc(calc(1 / 2 * 100%) * -1);
            translate: var(--tw-translate-x) var(--tw-translate-y);
          }
          .cursor-not-allowed {
            cursor: not-allowed;
          }
          .cursor-pointer {
            cursor: pointer;
          }
          .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
          }
          .flex-col {
            flex-direction: column;
          }
          .items-center {
            align-items: center;
          }
          .items-start {
            align-items: flex-start;
          }
          .justify-between {
            justify-content: space-between;
          }
          .justify-center {
            justify-content: center;
          }
          .justify-end {
            justify-content: flex-end;
          }
          .gap-1 {
            gap: calc(var(--spacing) * 1);
          }
          .gap-1\.5 {
            gap: calc(var(--spacing) * 1.5);
          }
          .gap-2 {
            gap: calc(var(--spacing) * 2);
          }
          .gap-3 {
            gap: calc(var(--spacing) * 3);
          }
          .gap-4 {
            gap: calc(var(--spacing) * 4);
          }
          .gap-5 {
            gap: calc(var(--spacing) * 5);
          }
          .gap-6 {
            gap: calc(var(--spacing) * 6);
          }
          .space-y-1 {
            :where(& > :not(:last-child)) {
              --tw-space-y-reverse: 0;
              margin-block-start: calc(
                calc(var(--spacing) * 1) * var(--tw-space-y-reverse)
              );
              margin-block-end: calc(
                calc(var(--spacing) * 1) * calc(1 - var(--tw-space-y-reverse))
              );
            }
          }
          .divide-y {
            :where(& > :not(:last-child)) {
              --tw-divide-y-reverse: 0;
              border-bottom-style: var(--tw-border-style);
              border-top-style: var(--tw-border-style);
              border-top-width: calc(1px * var(--tw-divide-y-reverse));
              border-bottom-width: calc(
                1px * calc(1 - var(--tw-divide-y-reverse))
              );
            }
          }
          .divide-border {
            :where(& > :not(:last-child)) {
              border-color: var(--color-border);
            }
          }
          .overflow-hidden {
            overflow: hidden;
          }
          .overflow-x-auto {
            overflow-x: auto;
          }
          .overflow-y-auto {
            overflow-y: auto;
          }
          .rounded-full {
            border-radius: calc(infinity * 1px);
          }
          .rounded-lg {
            border-radius: var(--radius-lg);
          }
          .rounded-md {
            border-radius: var(--radius-md);
          }
          .border {
            border-style: var(--tw-border-style);
            border-width: 1px;
          }
          .border-t {
            border-top-style: var(--tw-border-style);
            border-top-width: 1px;
          }
          .border-r {
            border-right-style: var(--tw-border-style);
            border-right-width: 1px;
          }
          .border-b {
            border-bottom-style: var(--tw-border-style);
            border-bottom-width: 1px;
          }
          .border-l {
            border-left-style: var(--tw-border-style);
            border-left-width: 1px;
          }
          .border-border {
            border-color: var(--color-border);
          }
          .border-destructive\/20 {
            border-color: color-mix(in srgb, #ef4444 20%, transparent);
            @supports (color: color-mix(in lab, red, red)) {
              border-color: color-mix(
                in oklab,
                var(--color-destructive) 20%,
                transparent
              );
            }
          }
          .border-destructive\/50 {
            border-color: color-mix(in srgb, #ef4444 50%, transparent);
            @supports (color: color-mix(in lab, red, red)) {
              border-color: color-mix(
                in oklab,
                var(--color-destructive) 50%,
                transparent
              );
            }
          }
          .border-primary\/20 {
            border-color: color-mix(in srgb, #4169e1 20%, transparent);
            @supports (color: color-mix(in lab, red, red)) {
              border-color: color-mix(
                in oklab,
                var(--color-primary) 20%,
                transparent
              );
            }
          }
          .border-sidebar-border {
            border-color: var(--color-sidebar-border);
          }
          .border-success\/20 {
            border-color: color-mix(in srgb, #10b981 20%, transparent);
            @supports (color: color-mix(in lab, red, red)) {
              border-color: color-mix(
                in oklab,
                var(--color-success) 20%,
                transparent
              );
            }
          }
          .border-warning\/20 {
            border-color: color-mix(in srgb, #f59e0b 20%, transparent);
            @supports (color: color-mix(in lab, red, red)) {
              border-color: color-mix(
                in oklab,
                var(--color-warning) 20%,
                transparent
              );
            }
          }
          .border-warning\/50 {
            border-color: color-mix(in srgb, #f59e0b 50%, transparent);
            @supports (color: color-mix(in lab, red, red)) {
              border-color: color-mix(
                in oklab,
                var(--color-warning) 50%,
                transparent
              );
            }
          }
          .bg-accent {
            background-color: var(--color-accent);
          }
          .bg-background {
            background-color: var(--color-background);
          }
          .bg-destructive {
            background-color: var(--color-destructive);
          }
          .bg-destructive\/10 {
            background-color: color-mix(in srgb, #ef4444 10%, transparent);
            @supports (color: color-mix(in lab, red, red)) {
              background-color: color-mix(
                in oklab,
                var(--color-destructive) 10%,
                transparent
              );
            }
          }
          .bg-foreground\/20 {
            background-color: color-mix(in srgb, #000000 20%, transparent);
            @supports (color: color-mix(in lab, red, red)) {
              background-color: color-mix(
                in oklab,
                var(--color-foreground) 20%,
                transparent
              );
            }
          }
          .bg-input {
            background-color: var(--color-input);
          }
          .bg-muted {
            background-color: var(--color-muted);
          }
          .bg-muted-foreground {
            background-color: var(--color-muted-foreground);
          }
          .bg-primary {
            background-color: var(--color-primary);
          }
          .bg-primary\/10 {
            background-color: color-mix(in srgb, #4169e1 10%, transparent);
            @supports (color: color-mix(in lab, red, red)) {
              background-color: color-mix(
                in oklab,
                var(--color-primary) 10%,
                transparent
              );
            }
          }
          .bg-secondary {
            background-color: var(--color-secondary);
          }
          .bg-secondary\/30 {
            background-color: color-mix(in srgb, #f3f4f6 30%, transparent);
            @supports (color: color-mix(in lab, red, red)) {
              background-color: color-mix(
                in oklab,
                var(--color-secondary) 30%,
                transparent
              );
            }
          }
          .bg-secondary\/50 {
            background-color: color-mix(in srgb, #f3f4f6 50%, transparent);
            @supports (color: color-mix(in lab, red, red)) {
              background-color: color-mix(
                in oklab,
                var(--color-secondary) 50%,
                transparent
              );
            }
          }
          .bg-sidebar {
            background-color: var(--color-sidebar);
          }
          .bg-sidebar-active {
            background-color: var(--color-sidebar-active);
          }
          .bg-success {
            background-color: var(--color-success);
          }
          .bg-success-light {
            background-color: var(--color-success-light);
          }
          .bg-surface {
            background-color: var(--color-surface);
          }
          .bg-warning {
            background-color: var(--color-warning);
          }
          .bg-warning-light {
            background-color: var(--color-warning-light);
          }
          .p-1 {
            padding: calc(var(--spacing) * 1);
          }
          .p-1\.5 {
            padding: calc(var(--spacing) * 1.5);
          }
          .p-2 {
            padding: calc(var(--spacing) * 2);
          }
          .p-4 {
            padding: calc(var(--spacing) * 4);
          }
          .p-5 {
            padding: calc(var(--spacing) * 5);
          }
          .p-6 {
            padding: calc(var(--spacing) * 6);
          }
          .px-2 {
            padding-inline: calc(var(--spacing) * 2);
          }
          .px-2\.5 {
            padding-inline: calc(var(--spacing) * 2.5);
          }
          .px-3 {
            padding-inline: calc(var(--spacing) * 3);
          }
          .px-4 {
            padding-inline: calc(var(--spacing) * 4);
          }
          .px-6 {
            padding-inline: calc(var(--spacing) * 6);
          }
          .py-0\.5 {
            padding-block: calc(var(--spacing) * 0.5);
          }
          .py-1 {
            padding-block: calc(var(--spacing) * 1);
          }
          .py-1\.5 {
            padding-block: calc(var(--spacing) * 1.5);
          }
          .py-2 {
            padding-block: calc(var(--spacing) * 2);
          }
          .py-2\.5 {
            padding-block: calc(var(--spacing) * 2.5);
          }
          .py-3 {
            padding-block: calc(var(--spacing) * 3);
          }
          .py-4 {
            padding-block: calc(var(--spacing) * 4);
          }
          .py-5 {
            padding-block: calc(var(--spacing) * 5);
          }
          .pt-2 {
            padding-top: calc(var(--spacing) * 2);
          }
          .pr-4 {
            padding-right: calc(var(--spacing) * 4);
          }
          .pl-9 {
            padding-left: calc(var(--spacing) * 9);
          }
          .text-left {
            text-align: left;
          }
          .text-right {
            text-align: right;
          }
          .font-body {
            font-family: var(--font-body);
          }
          .font-headings {
            font-family: var(--font-headings);
          }
          .text-2xl {
            font-size: var(--text-2xl);
            line-height: var(--tw-leading, var(--text-2xl--line-height));
          }
          .text-lg {
            font-size: var(--text-lg);
            line-height: var(--tw-leading, var(--text-lg--line-height));
          }
          .text-sm {
            font-size: var(--text-sm);
            line-height: var(--tw-leading, var(--text-sm--line-height));
          }
          .text-xs {
            font-size: var(--text-xs);
            line-height: var(--tw-leading, var(--text-xs--line-height));
          }
          .text-\[10px\] {
            font-size: 10px;
          }
          .font-bold {
            --tw-font-weight: var(--font-weight-bold);
            font-weight: var(--font-weight-bold);
          }
          .font-medium {
            --tw-font-weight: var(--font-weight-medium);
            font-weight: var(--font-weight-medium);
          }
          .font-normal {
            --tw-font-weight: var(--font-weight-normal);
            font-weight: var(--font-weight-normal);
          }
          .font-semibold {
            --tw-font-weight: var(--font-weight-semibold);
            font-weight: var(--font-weight-semibold);
          }
          .tracking-wider {
            --tw-tracking: var(--tracking-wider);
            letter-spacing: var(--tracking-wider);
          }
          .whitespace-nowrap {
            white-space: nowrap;
          }
          .text-accent-foreground {
            color: var(--color-accent-foreground);
          }
          .text-destructive {
            color: var(--color-destructive);
          }
          .text-destructive-foreground {
            color: var(--color-destructive-foreground);
          }
          .text-foreground {
            color: var(--color-foreground);
          }
          .text-muted-foreground {
            color: var(--color-muted-foreground);
          }
          .text-primary {
            color: var(--color-primary);
          }
          .text-primary-foreground {
            color: var(--color-primary-foreground);
          }
          .text-secondary-foreground {
            color: var(--color-secondary-foreground);
          }
          .text-sidebar-active-text {
            color: var(--color-sidebar-active-text);
          }
          .text-sidebar-text {
            color: var(--color-sidebar-text);
          }
          .text-success {
            color: var(--color-success);
          }
          .text-success-text {
            color: var(--color-success-text);
          }
          .text-warning {
            color: var(--color-warning);
          }
          .text-warning-text {
            color: var(--color-warning-text);
          }
          .uppercase {
            text-transform: uppercase;
          }
          .opacity-70 {
            opacity: 70%;
          }
          .shadow-\[0_0_15px_rgba\(245\,158\,11\,0\.1\)\] {
            --tw-shadow: 0 0 15px
              var(--tw-shadow-color, rgba(245, 158, 11, 0.1));
            box-shadow:
              var(--tw-inset-shadow), var(--tw-inset-ring-shadow),
              var(--tw-ring-offset-shadow), var(--tw-ring-shadow),
              var(--tw-shadow);
          }
          .shadow-sm {
            --tw-shadow:
              0 1px 3px 0 var(--tw-shadow-color, rgb(0 0 0 / 0.1)),
              0 1px 2px -1px var(--tw-shadow-color, rgb(0 0 0 / 0.1));
            box-shadow:
              var(--tw-inset-shadow), var(--tw-inset-ring-shadow),
              var(--tw-ring-offset-shadow), var(--tw-ring-shadow),
              var(--tw-shadow);
          }
          .shadow-xl {
            --tw-shadow:
              0 20px 25px -5px var(--tw-shadow-color, rgb(0 0 0 / 0.1)),
              0 8px 10px -6px var(--tw-shadow-color, rgb(0 0 0 / 0.1));
            box-shadow:
              var(--tw-inset-shadow), var(--tw-inset-ring-shadow),
              var(--tw-ring-offset-shadow), var(--tw-ring-shadow),
              var(--tw-shadow);
          }
          .backdrop-blur-sm {
            --tw-backdrop-blur: blur(var(--blur-sm));
            -webkit-backdrop-filter: var(--tw-backdrop-blur,)
              var(--tw-backdrop-brightness,) var(--tw-backdrop-contrast,)
              var(--tw-backdrop-grayscale,) var(--tw-backdrop-hue-rotate,)
              var(--tw-backdrop-invert,) var(--tw-backdrop-opacity,)
              var(--tw-backdrop-saturate,) var(--tw-backdrop-sepia,);
            backdrop-filter: var(--tw-backdrop-blur,)
              var(--tw-backdrop-brightness,) var(--tw-backdrop-contrast,)
              var(--tw-backdrop-grayscale,) var(--tw-backdrop-hue-rotate,)
              var(--tw-backdrop-invert,) var(--tw-backdrop-opacity,)
              var(--tw-backdrop-saturate,) var(--tw-backdrop-sepia,);
          }
          .transition-colors {
            transition-property:
              color, background-color, border-color, outline-color,
              text-decoration-color, fill, stroke, --tw-gradient-from,
              --tw-gradient-via, --tw-gradient-to;
            transition-timing-function: var(
              --tw-ease,
              var(--default-transition-timing-function)
            );
            transition-duration: var(
              --tw-duration,
              var(--default-transition-duration)
            );
          }
          .hover\:border-primary {
            &:hover {
              @media (hover: hover) {
                border-color: var(--color-primary);
              }
            }
          }
          .hover\:bg-accent\/90 {
            &:hover {
              @media (hover: hover) {
                background-color: color-mix(in srgb, #000000 90%, transparent);
                @supports (color: color-mix(in lab, red, red)) {
                  background-color: color-mix(
                    in oklab,
                    var(--color-accent) 90%,
                    transparent
                  );
                }
              }
            }
          }
          .hover\:bg-destructive\/10 {
            &:hover {
              @media (hover: hover) {
                background-color: color-mix(in srgb, #ef4444 10%, transparent);
                @supports (color: color-mix(in lab, red, red)) {
                  background-color: color-mix(
                    in oklab,
                    var(--color-destructive) 10%,
                    transparent
                  );
                }
              }
            }
          }
          .hover\:bg-primary-hover {
            &:hover {
              @media (hover: hover) {
                background-color: var(--color-primary-hover);
              }
            }
          }
          .hover\:bg-primary\/10 {
            &:hover {
              @media (hover: hover) {
                background-color: color-mix(in srgb, #4169e1 10%, transparent);
                @supports (color: color-mix(in lab, red, red)) {
                  background-color: color-mix(
                    in oklab,
                    var(--color-primary) 10%,
                    transparent
                  );
                }
              }
            }
          }
          .hover\:bg-primary\/90 {
            &:hover {
              @media (hover: hover) {
                background-color: color-mix(in srgb, #4169e1 90%, transparent);
                @supports (color: color-mix(in lab, red, red)) {
                  background-color: color-mix(
                    in oklab,
                    var(--color-primary) 90%,
                    transparent
                  );
                }
              }
            }
          }
          .hover\:bg-secondary {
            &:hover {
              @media (hover: hover) {
                background-color: var(--color-secondary);
              }
            }
          }
          .hover\:bg-secondary\/30 {
            &:hover {
              @media (hover: hover) {
                background-color: color-mix(in srgb, #f3f4f6 30%, transparent);
                @supports (color: color-mix(in lab, red, red)) {
                  background-color: color-mix(
                    in oklab,
                    var(--color-secondary) 30%,
                    transparent
                  );
                }
              }
            }
          }
          .hover\:bg-sidebar-active\/50 {
            &:hover {
              @media (hover: hover) {
                background-color: color-mix(in srgb, #f3f4f6 50%, transparent);
                @supports (color: color-mix(in lab, red, red)) {
                  background-color: color-mix(
                    in oklab,
                    var(--color-sidebar-active) 50%,
                    transparent
                  );
                }
              }
            }
          }
          .hover\:text-destructive {
            &:hover {
              @media (hover: hover) {
                color: var(--color-destructive);
              }
            }
          }
          .hover\:text-foreground {
            &:hover {
              @media (hover: hover) {
                color: var(--color-foreground);
              }
            }
          }
          .hover\:text-primary {
            &:hover {
              @media (hover: hover) {
                color: var(--color-primary);
              }
            }
          }
          .hover\:text-primary-hover {
            &:hover {
              @media (hover: hover) {
                color: var(--color-primary-hover);
              }
            }
          }
          .hover\:text-sidebar-active-text {
            &:hover {
              @media (hover: hover) {
                color: var(--color-sidebar-active-text);
              }
            }
          }
          .focus\:ring-2 {
            &:focus {
              --tw-ring-shadow: var(--tw-ring-inset,) 0 0 0
                calc(2px + var(--tw-ring-offset-width))
                var(--tw-ring-color, currentcolor);
              box-shadow:
                var(--tw-inset-shadow), var(--tw-inset-ring-shadow),
                var(--tw-ring-offset-shadow), var(--tw-ring-shadow),
                var(--tw-shadow);
            }
          }
          .focus\:ring-offset-2 {
            &:focus {
              --tw-ring-offset-width: 2px;
              --tw-ring-offset-shadow: var(--tw-ring-inset,) 0 0 0
                var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            }
          }
          .focus\:outline-none {
            &:focus {
              --tw-outline-style: none;
              outline-style: none;
            }
          }
          .disabled\:pointer-events-none {
            &:disabled {
              pointer-events: none;
            }
          }
          .disabled\:opacity-50 {
            &:disabled {
              opacity: 50%;
            }
          }
          .sm\:inline {
            @media (width >= 40rem) {
              display: inline;
            }
          }
          .sm\:w-64 {
            @media (width >= 40rem) {
              width: calc(var(--spacing) * 64);
            }
          }
          .sm\:w-auto {
            @media (width >= 40rem) {
              width: auto;
            }
          }
          .sm\:flex-row {
            @media (width >= 40rem) {
              flex-direction: row;
            }
          }
          .sm\:items-center {
            @media (width >= 40rem) {
              align-items: center;
            }
          }
          .md\:grid-cols-2 {
            @media (width >= 48rem) {
              grid-template-columns: repeat(2, minmax(0, 1fr));
            }
          }
          .lg\:col-span-1 {
            @media (width >= 64rem) {
              grid-column: span 1 / span 1;
            }
          }
          .lg\:col-span-2 {
            @media (width >= 64rem) {
              grid-column: span 2 / span 2;
            }
          }
          .lg\:grid-cols-3 {
            @media (width >= 64rem) {
              grid-template-columns: repeat(3, minmax(0, 1fr));
            }
          }
          .lg\:grid-cols-4 {
            @media (width >= 64rem) {
              grid-template-columns: repeat(4, minmax(0, 1fr));
            }
          }
        }
        @property --tw-translate-x {
          syntax: "*";
          inherits: false;
          initial-value: 0;
        }
        @property --tw-translate-y {
          syntax: "*";
          inherits: false;
          initial-value: 0;
        }
        @property --tw-translate-z {
          syntax: "*";
          inherits: false;
          initial-value: 0;
        }
        @property --tw-space-y-reverse {
          syntax: "*";
          inherits: false;
          initial-value: 0;
        }
        @property --tw-divide-y-reverse {
          syntax: "*";
          inherits: false;
          initial-value: 0;
        }
        @property --tw-border-style {
          syntax: "*";
          inherits: false;
          initial-value: solid;
        }
        @property --tw-font-weight {
          syntax: "*";
          inherits: false;
        }
        @property --tw-tracking {
          syntax: "*";
          inherits: false;
        }
        @property --tw-shadow {
          syntax: "*";
          inherits: false;
          initial-value: 0 0 #0000;
        }
        @property --tw-shadow-color {
          syntax: "*";
          inherits: false;
        }
        @property --tw-shadow-alpha {
          syntax: "<percentage>";
          inherits: false;
          initial-value: 100%;
        }
        @property --tw-inset-shadow {
          syntax: "*";
          inherits: false;
          initial-value: 0 0 #0000;
        }
        @property --tw-inset-shadow-color {
          syntax: "*";
          inherits: false;
        }
        @property --tw-inset-shadow-alpha {
          syntax: "<percentage>";
          inherits: false;
          initial-value: 100%;
        }
        @property --tw-ring-color {
          syntax: "*";
          inherits: false;
        }
        @property --tw-ring-shadow {
          syntax: "*";
          inherits: false;
          initial-value: 0 0 #0000;
        }
        @property --tw-inset-ring-color {
          syntax: "*";
          inherits: false;
        }
        @property --tw-inset-ring-shadow {
          syntax: "*";
          inherits: false;
          initial-value: 0 0 #0000;
        }
        @property --tw-ring-inset {
          syntax: "*";
          inherits: false;
        }
        @property --tw-ring-offset-width {
          syntax: "<length>";
          inherits: false;
          initial-value: 0px;
        }
        @property --tw-ring-offset-color {
          syntax: "*";
          inherits: false;
          initial-value: #fff;
        }
        @property --tw-ring-offset-shadow {
          syntax: "*";
          inherits: false;
          initial-value: 0 0 #0000;
        }
        @property --tw-backdrop-blur {
          syntax: "*";
          inherits: false;
        }
        @property --tw-backdrop-brightness {
          syntax: "*";
          inherits: false;
        }
        @property --tw-backdrop-contrast {
          syntax: "*";
          inherits: false;
        }
        @property --tw-backdrop-grayscale {
          syntax: "*";
          inherits: false;
        }
        @property --tw-backdrop-hue-rotate {
          syntax: "*";
          inherits: false;
        }
        @property --tw-backdrop-invert {
          syntax: "*";
          inherits: false;
        }
        @property --tw-backdrop-opacity {
          syntax: "*";
          inherits: false;
        }
        @property --tw-backdrop-saturate {
          syntax: "*";
          inherits: false;
        }
        @property --tw-backdrop-sepia {
          syntax: "*";
          inherits: false;
        }
        @layer properties {
          @supports ((-webkit-hyphens: none) and (not (margin-trim: inline))) or
            ((-moz-orient: inline) and (not (color: rgb(from red r g b)))) {
            *,
            ::before,
            ::after,
            ::backdrop {
              --tw-translate-x: 0;
              --tw-translate-y: 0;
              --tw-translate-z: 0;
              --tw-space-y-reverse: 0;
              --tw-divide-y-reverse: 0;
              --tw-border-style: solid;
              --tw-font-weight: initial;
              --tw-tracking: initial;
              --tw-shadow: 0 0 #0000;
              --tw-shadow-color: initial;
              --tw-shadow-alpha: 100%;
              --tw-inset-shadow: 0 0 #0000;
              --tw-inset-shadow-color: initial;
              --tw-inset-shadow-alpha: 100%;
              --tw-ring-color: initial;
              --tw-ring-shadow: 0 0 #0000;
              --tw-inset-ring-color: initial;
              --tw-inset-ring-shadow: 0 0 #0000;
              --tw-ring-inset: initial;
              --tw-ring-offset-width: 0px;
              --tw-ring-offset-color: #fff;
              --tw-ring-offset-shadow: 0 0 #0000;
              --tw-backdrop-blur: initial;
              --tw-backdrop-brightness: initial;
              --tw-backdrop-contrast: initial;
              --tw-backdrop-grayscale: initial;
              --tw-backdrop-hue-rotate: initial;
              --tw-backdrop-invert: initial;
              --tw-backdrop-opacity: initial;
              --tw-backdrop-saturate: initial;
              --tw-backdrop-sepia: initial;
            }
          }
        }
      </style>
    </head>
    <body>
      <div class="flex h-screen w-full bg-background font-body overflow-hidden">
        <div class="flex flex-col flex-1 min-w-0">
          <header
            class="h-16 bg-surface border-b border-border flex items-center justify-between px-6 shrink-0"
          >
            <div class="flex items-center gap-2 text-sm text-muted-foreground">
              <a
                class="hover:text-foreground transition-colors"
                data-media-type="banani-button"
                ><span data-file="/components/Header.jsx" data-idx="0"
                  >Branch Management</span
                ></a
              >
              <div class="flex items-center gap-2">
                <iconify-icon
                  icon="lucide:chevron-right"
                  class="block size-[16px]"
                  style="font-size: 16px"
                ></iconify-icon
                ><a
                  class="hover:text-foreground transition-colors font-medium text-foreground"
                  data-media-type="banani-button"
                  ><span
                    data-file="/screens/InventoryManagement_copy1.jsx"
                    data-idx="15"
                    >Inventory</span
                  ></a
                >
              </div>
            </div>
            <div class="flex items-center gap-4">
              <div class="relative">
                <iconify-icon
                  icon="lucide:bell"
                  class="block text-muted-foreground hover:text-foreground transition-colors size-[20px]"
                  style="font-size: 20px"
                ></iconify-icon
                ><span
                  class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-destructive text-[10px] font-bold text-destructive-foreground"
                  >3</span
                >
              </div>
              <div
                class="h-8 w-8 rounded-full bg-secondary flex items-center justify-center overflow-hidden border border-border"
              >
                <iconify-icon
                  icon="lucide:user"
                  class="block text-muted-foreground size-[16px]"
                  style="font-size: 16px"
                ></iconify-icon>
              </div>
            </div>
          </header>
          <main class="flex-1 p-6 overflow-y-auto">
            <div class="flex flex-col gap-6">
              <div class="flex items-start justify-between">
                <div>
                  <h1
                    class="text-2xl font-headings font-bold text-foreground flex items-center gap-3"
                  >
                    <span
                      data-file="/screens/InventoryManagement_copy1.jsx"
                      data-idx="16"
                      >Inventory Management</span
                    ><span
                      class="text-xs font-normal bg-secondary text-secondary-foreground px-2 py-1 rounded-full border border-border"
                      ><span
                        data-file="/screens/InventoryManagement_copy1.jsx"
                        data-idx="17"
                        >Branch: Colombo-01</span
                      ></span
                    >
                  </h1>
                  <p class="text-muted-foreground text-sm mt-1">
                    <span
                      data-file="/screens/InventoryManagement_copy1.jsx"
                      data-idx="18"
                      >Manage and monitor stock levels for your assigned
                      branch.</span
                    >
                  </p>
                </div>
                <div class="flex items-center gap-3">
                  <button
                    class="flex items-center gap-2 px-4 py-2 border border-border bg-surface text-sm font-medium rounded-md hover:bg-secondary transition-colors"
                    data-media-type="banani-button"
                  >
                    <iconify-icon
                      icon="lucide:download"
                      class="block size-[16px]"
                      style="font-size: 16px"
                    ></iconify-icon
                    ><span
                      data-file="/screens/InventoryManagement_copy1.jsx"
                      data-idx="19"
                      >Export</span
                    ></button
                  ><button
                    class="flex items-center gap-2 px-4 py-2 bg-primary text-primary-foreground text-sm font-medium rounded-md shadow-sm hover:bg-primary/90 transition-colors"
                    data-media-type="banani-button"
                  >
                    <iconify-icon
                      icon="lucide:plus"
                      class="block size-[16px]"
                      style="font-size: 16px"
                    ></iconify-icon
                    ><span
                      data-file="/screens/InventoryManagement_copy1.jsx"
                      data-idx="20"
                      >Add Stock</span
                    >
                  </button>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div
                  class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden"
                >
                  <div class="p-6 p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                      <span class="text-sm font-medium text-muted-foreground"
                        ><span
                          data-file="/screens/InventoryManagement_copy1.jsx"
                          data-idx="21"
                          >Total Items in Stock</span
                        ></span
                      >
                      <div class="p-2 rounded-md bg-secondary text-primary">
                        <iconify-icon
                          icon="lucide:package"
                          class="block size-[18px]"
                          style="font-size: 18px"
                        ></iconify-icon>
                      </div>
                    </div>
                    <div>
                      <div
                        class="text-2xl font-headings font-bold text-foreground"
                      >
                        4,291
                      </div>
                      <div class="flex items-center gap-1 mt-1 text-xs">
                        <iconify-icon
                          icon="lucide:trending-up"
                          class="block text-success size-[14px]"
                          style="font-size: 14px"
                        ></iconify-icon
                        ><span class="text-success-text"
                          ><span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="22"
                            >+12% from last month</span
                          ></span
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden border-warning/50 shadow-[0_0_15px_rgba(245,158,11,0.1)]"
                >
                  <div class="p-6 p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                      <span class="text-sm font-medium text-muted-foreground"
                        ><span
                          data-file="/screens/InventoryManagement_copy1.jsx"
                          data-idx="23"
                          >Low Stock Alerts</span
                        ></span
                      >
                      <div
                        class="p-2 rounded-md bg-warning-light text-warning-text"
                      >
                        <iconify-icon
                          icon="lucide:alert-triangle"
                          class="block size-[18px]"
                          style="font-size: 18px"
                        ></iconify-icon>
                      </div>
                    </div>
                    <div>
                      <div
                        class="text-2xl font-headings font-bold text-foreground"
                      >
                        23
                      </div>
                      <div class="flex items-center gap-1 mt-1 text-xs">
                        <iconify-icon
                          icon="lucide:alert-triangle"
                          class="block text-warning size-[14px]"
                          style="font-size: 14px"
                        ></iconify-icon
                        ><span class="text-warning-text"
                          ><span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="24"
                            >5 items critical</span
                          ></span
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden"
                >
                  <div class="p-6 p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                      <span class="text-sm font-medium text-muted-foreground"
                        ><span
                          data-file="/screens/InventoryManagement_copy1.jsx"
                          data-idx="25"
                          >Total Categories</span
                        ></span
                      >
                      <div class="p-2 rounded-md bg-secondary text-primary">
                        <iconify-icon
                          icon="lucide:layers"
                          class="block size-[18px]"
                          style="font-size: 18px"
                        ></iconify-icon>
                      </div>
                    </div>
                    <div>
                      <div
                        class="text-2xl font-headings font-bold text-foreground"
                      >
                        15
                      </div>
                      <div class="flex items-center gap-1 mt-1 text-xs">
                        <span class="text-muted-foreground"
                          ><span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="26"
                            >No change</span
                          ></span
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden"
                >
                  <div class="p-6 p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                      <span class="text-sm font-medium text-muted-foreground"
                        ><span
                          data-file="/screens/InventoryManagement_copy1.jsx"
                          data-idx="27"
                          >Recent Adjustments</span
                        ></span
                      >
                      <div class="p-2 rounded-md bg-secondary text-primary">
                        <iconify-icon
                          icon="lucide:edit-3"
                          class="block size-[18px]"
                          style="font-size: 18px"
                        ></iconify-icon>
                      </div>
                    </div>
                    <div>
                      <div
                        class="text-2xl font-headings font-bold text-foreground"
                      >
                        142
                      </div>
                      <div class="flex items-center gap-1 mt-1 text-xs">
                        <iconify-icon
                          icon="lucide:trending-down"
                          class="block text-destructive size-[14px]"
                          style="font-size: 14px"
                        ></iconify-icon
                        ><span class="text-destructive"
                          ><span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="28"
                            >-5% vs last week</span
                          ></span
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden flex-1"
              >
                <div
                  class="px-6 py-4 border-b border-border flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                >
                  <h3
                    class="font-headings font-semibold text-lg text-foreground"
                  >
                    <span
                      data-file="/screens/InventoryManagement_copy1.jsx"
                      data-idx="29"
                      >Current Stock</span
                    >
                  </h3>
                  <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="relative flex-1 sm:w-64">
                      <iconify-icon
                        icon="lucide:search"
                        class="block absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground size-[16px]"
                        style="font-size: 16px"
                      ></iconify-icon>
                      <div
                        class="w-full pl-9 pr-4 py-2 bg-input border border-border rounded-md text-sm text-muted-foreground"
                      >
                        <span
                          data-file="/screens/InventoryManagement_copy1.jsx"
                          data-idx="30"
                          >Search items...</span
                        >
                      </div>
                    </div>
                    <button
                      class="flex items-center gap-2 px-3 py-2 border border-border bg-surface text-sm rounded-md hover:bg-secondary transition-colors"
                      data-media-type="banani-button"
                    >
                      <iconify-icon
                        icon="lucide:filter"
                        class="block size-[16px]"
                        style="font-size: 16px"
                      ></iconify-icon
                      ><span class="hidden sm:inline"
                        ><span
                          data-file="/screens/InventoryManagement_copy1.jsx"
                          data-idx="31"
                          >Filter</span
                        ></span
                      >
                    </button>
                  </div>
                </div>
                <div class="overflow-x-auto">
                  <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                      <tr class="bg-secondary/50 border-b border-border">
                        <th
                          class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider"
                        >
                          <span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="32"
                            >Item Details</span
                          >
                        </th>
                        <th
                          class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider"
                        >
                          <span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="33"
                            >Category</span
                          >
                        </th>
                        <th
                          class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider"
                        >
                          <span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="34"
                            >Stock Quantity</span
                          >
                        </th>
                        <th
                          class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider"
                        >
                          <span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="35"
                            >Status</span
                          >
                        </th>
                        <th
                          class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider text-right"
                        >
                          <span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="36"
                            >Actions</span
                          >
                        </th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                      <tr class="hover:bg-secondary/30 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex flex-col">
                            <span class="font-medium text-foreground"
                              ><span
                                data-file="/screens/InventoryManagement_copy1.jsx"
                                data-idx="0"
                                >Organic Coffee Beans</span
                              ></span
                            ><span class="text-xs text-muted-foreground"
                              >ITM-001</span
                            >
                          </div>
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-sm text-foreground"
                        >
                          <span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="1"
                            >Beverages</span
                          >
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span
                            class="font-headings font-semibold text-foreground"
                            >125</span
                          >
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-success-light text-success-text border-success/20"
                            ><span
                              class="w-1.5 h-1.5 rounded-full bg-success mr-1.5"
                            ></span
                            >In Stock</span
                          >
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                          <div class="flex items-center justify-end gap-2">
                            <button
                              class="p-1.5 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded-md transition-colors"
                              title="Adjust Stock"
                              data-media-type="banani-button"
                            >
                              <iconify-icon
                                icon="lucide:edit-2"
                                class="block size-[16px]"
                                style="font-size: 16px"
                              ></iconify-icon></button
                            ><button
                              class="p-1.5 text-muted-foreground hover:text-destructive hover:bg-destructive/10 rounded-md transition-colors"
                              title="Delete Record"
                              data-media-type="banani-button"
                            >
                              <iconify-icon
                                icon="lucide:trash-2"
                                class="block size-[16px]"
                                style="font-size: 16px"
                              ></iconify-icon>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr class="hover:bg-secondary/30 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex flex-col">
                            <span class="font-medium text-foreground"
                              ><span
                                data-file="/screens/InventoryManagement_copy1.jsx"
                                data-idx="3"
                                >Almond Milk (1L)</span
                              ></span
                            ><span class="text-xs text-muted-foreground"
                              >ITM-002</span
                            >
                          </div>
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-sm text-foreground"
                        >
                          <span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="4"
                            >Dairy Alt.</span
                          >
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span
                            class="font-headings font-semibold text-foreground"
                            >12</span
                          >
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-warning-light text-warning-text border-warning/20"
                            ><span
                              class="w-1.5 h-1.5 rounded-full bg-warning mr-1.5"
                            ></span
                            >Low Stock</span
                          >
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                          <div class="flex items-center justify-end gap-2">
                            <button
                              class="p-1.5 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded-md transition-colors"
                              title="Adjust Stock"
                              data-media-type="banani-button"
                            >
                              <iconify-icon
                                icon="lucide:edit-2"
                                class="block size-[16px]"
                                style="font-size: 16px"
                              ></iconify-icon></button
                            ><button
                              class="p-1.5 text-muted-foreground hover:text-destructive hover:bg-destructive/10 rounded-md transition-colors"
                              title="Delete Record"
                              data-media-type="banani-button"
                            >
                              <iconify-icon
                                icon="lucide:trash-2"
                                class="block size-[16px]"
                                style="font-size: 16px"
                              ></iconify-icon>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr class="hover:bg-secondary/30 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex flex-col">
                            <span class="font-medium text-foreground"
                              ><span
                                data-file="/screens/InventoryManagement_copy1.jsx"
                                data-idx="6"
                                >Avocado (Box)</span
                              ></span
                            ><span class="text-xs text-muted-foreground"
                              >ITM-003</span
                            >
                          </div>
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-sm text-foreground"
                        >
                          <span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="7"
                            >Produce</span
                          >
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span
                            class="font-headings font-semibold text-foreground"
                            >0</span
                          >
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-muted text-muted-foreground border-border"
                            ><span
                              class="w-1.5 h-1.5 rounded-full bg-muted-foreground mr-1.5"
                            ></span
                            >Out of Stock</span
                          >
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                          <div class="flex items-center justify-end gap-2">
                            <button
                              class="p-1.5 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded-md transition-colors"
                              title="Adjust Stock"
                              data-media-type="banani-button"
                            >
                              <iconify-icon
                                icon="lucide:edit-2"
                                class="block size-[16px]"
                                style="font-size: 16px"
                              ></iconify-icon></button
                            ><button
                              class="p-1.5 text-muted-foreground hover:text-destructive hover:bg-destructive/10 rounded-md transition-colors"
                              title="Delete Record"
                              data-media-type="banani-button"
                            >
                              <iconify-icon
                                icon="lucide:trash-2"
                                class="block size-[16px]"
                                style="font-size: 16px"
                              ></iconify-icon>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr class="hover:bg-secondary/30 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex flex-col">
                            <span class="font-medium text-foreground"
                              ><span
                                data-file="/screens/InventoryManagement_copy1.jsx"
                                data-idx="9"
                                >Brown Sugar (1kg)</span
                              ></span
                            ><span class="text-xs text-muted-foreground"
                              >ITM-004</span
                            >
                          </div>
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-sm text-foreground"
                        >
                          <span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="10"
                            >Pantry</span
                          >
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span
                            class="font-headings font-semibold text-foreground"
                            >84</span
                          >
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-success-light text-success-text border-success/20"
                            ><span
                              class="w-1.5 h-1.5 rounded-full bg-success mr-1.5"
                            ></span
                            >In Stock</span
                          >
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                          <div class="flex items-center justify-end gap-2">
                            <button
                              class="p-1.5 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded-md transition-colors"
                              title="Adjust Stock"
                              data-media-type="banani-button"
                            >
                              <iconify-icon
                                icon="lucide:edit-2"
                                class="block size-[16px]"
                                style="font-size: 16px"
                              ></iconify-icon></button
                            ><button
                              class="p-1.5 text-muted-foreground hover:text-destructive hover:bg-destructive/10 rounded-md transition-colors"
                              title="Delete Record"
                              data-media-type="banani-button"
                            >
                              <iconify-icon
                                icon="lucide:trash-2"
                                class="block size-[16px]"
                                style="font-size: 16px"
                              ></iconify-icon>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr class="hover:bg-secondary/30 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex flex-col">
                            <span class="font-medium text-foreground"
                              ><span
                                data-file="/screens/InventoryManagement_copy1.jsx"
                                data-idx="12"
                                >Matcha Powder</span
                              ></span
                            ><span class="text-xs text-muted-foreground"
                              >ITM-005</span
                            >
                          </div>
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-sm text-foreground"
                        >
                          <span
                            data-file="/screens/InventoryManagement_copy1.jsx"
                            data-idx="13"
                            >Beverages</span
                          >
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span
                            class="font-headings font-semibold text-foreground"
                            >5</span
                          >
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-destructive/10 text-destructive border-destructive/20"
                            ><span
                              class="w-1.5 h-1.5 rounded-full bg-destructive mr-1.5"
                            ></span
                            >Critical</span
                          >
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                          <div class="flex items-center justify-end gap-2">
                            <button
                              class="p-1.5 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded-md transition-colors"
                              title="Adjust Stock"
                              data-media-type="banani-button"
                            >
                              <iconify-icon
                                icon="lucide:edit-2"
                                class="block size-[16px]"
                                style="font-size: 16px"
                              ></iconify-icon></button
                            ><button
                              class="p-1.5 text-muted-foreground hover:text-destructive hover:bg-destructive/10 rounded-md transition-colors"
                              title="Delete Record"
                              data-media-type="banani-button"
                            >
                              <iconify-icon
                                icon="lucide:trash-2"
                                class="block size-[16px]"
                                style="font-size: 16px"
                              ></iconify-icon>
                            </button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div
                  class="px-6 py-4 border-t border-border flex items-center justify-between"
                >
                  <span class="text-sm text-muted-foreground"
                    ><span
                      data-file="/screens/InventoryManagement_copy1.jsx"
                      data-idx="39"
                      >Showing 1 to 5 of 4,291 entries</span
                    ></span
                  >
                  <div class="flex items-center gap-1">
                    <button
                      class="px-3 py-1 border border-border rounded-md text-sm text-muted-foreground hover:bg-secondary disabled:opacity-50"
                      disabled=""
                      data-media-type="banani-button"
                    >
                      <span
                        data-file="/screens/InventoryManagement_copy1.jsx"
                        data-idx="40"
                        >Prev</span
                      ></button
                    ><button
                      class="px-3 py-1 bg-primary text-primary-foreground rounded-md text-sm font-medium"
                      data-media-type="banani-button"
                    >
                      1</button
                    ><button
                      class="px-3 py-1 border border-border rounded-md text-sm hover:bg-secondary"
                      data-media-type="banani-button"
                    >
                      2</button
                    ><button
                      class="px-3 py-1 border border-border rounded-md text-sm hover:bg-secondary"
                      data-media-type="banani-button"
                    >
                      3</button
                    ><span class="px-2 text-muted-foreground">...</span
                    ><button
                      class="px-3 py-1 border border-border rounded-md text-sm text-foreground hover:bg-secondary"
                      data-media-type="banani-button"
                    >
                      <span
                        data-file="/screens/InventoryManagement_copy1.jsx"
                        data-idx="41"
                        >Next</span
                      >
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </main>
        </div>
        <div
          class="fixed inset-0 z-50 flex items-center justify-center bg-foreground/20 backdrop-blur-sm p-4"
        >
          <div
            class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden w-full max-w-md shadow-xl border-border"
          >
            <div
              class="px-6 py-4 border-b border-border flex items-center justify-between"
            >
              <h3 class="font-headings font-semibold text-lg text-foreground">
                <span
                  data-file="/screens/InventoryManagement_copy1.jsx"
                  data-idx="42"
                  >Add New Stock</span
                >
              </h3>
              <button
                class="text-muted-foreground hover:text-foreground transition-colors p-1 rounded-md hover:bg-secondary"
                data-media-type="banani-button"
              >
                <iconify-icon
                  icon="lucide:x"
                  class="block size-[20px]"
                  style="font-size: 20px"
                ></iconify-icon>
              </button>
            </div>
            <div class="p-6 flex flex-col gap-5">
              <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-foreground"
                  ><span
                    data-file="/screens/InventoryManagement_copy1.jsx"
                    data-idx="43"
                    >Item Name</span
                  ></label
                >
                <div
                  class="border border-border rounded-md px-3 py-2 bg-input text-muted-foreground text-sm"
                >
                  <span
                    data-file="/screens/InventoryManagement_copy1.jsx"
                    data-idx="44"
                    >e.g. Organic Coffee Beans</span
                  >
                </div>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-foreground"
                  ><span
                    data-file="/screens/InventoryManagement_copy1.jsx"
                    data-idx="45"
                    >Category</span
                  ></label
                >
                <div
                  class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm flex justify-between items-center cursor-pointer hover:border-primary transition-colors"
                  data-media-type="banani-button"
                >
                  <span
                    data-file="/screens/InventoryManagement_copy1.jsx"
                    data-idx="46"
                    >Select Category...</span
                  ><iconify-icon
                    icon="lucide:chevron-down"
                    class="block text-muted-foreground size-[16px]"
                    style="font-size: 16px"
                  ></iconify-icon>
                </div>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-foreground"
                  ><span
                    data-file="/screens/InventoryManagement_copy1.jsx"
                    data-idx="47"
                    >Quantity</span
                  ></label
                >
                <div
                  class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm flex justify-between items-center"
                >
                  <span class="text-muted-foreground"
                    ><span
                      data-file="/screens/InventoryManagement_copy1.jsx"
                      data-idx="48"
                      >0</span
                    ></span
                  >
                  <div class="flex flex-col">
                    <iconify-icon
                      icon="lucide:chevron-up"
                      class="block text-muted-foreground hover:text-foreground cursor-pointer size-[12px]"
                      style="font-size: 12px"
                    ></iconify-icon
                    ><iconify-icon
                      icon="lucide:chevron-down"
                      class="block text-muted-foreground hover:text-foreground cursor-pointer size-[12px]"
                      style="font-size: 12px"
                    ></iconify-icon>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="px-6 py-4 border-t border-border bg-secondary/30 flex items-center justify-end gap-3"
            >
              <button
                class="px-4 py-2 border border-border bg-surface text-sm font-medium rounded-md hover:bg-secondary transition-colors text-foreground"
                data-media-type="banani-button"
              >
                <span
                  data-file="/screens/InventoryManagement_copy1.jsx"
                  data-idx="49"
                  >Cancel</span
                ></button
              ><button
                class="px-4 py-2 bg-primary text-primary-foreground text-sm font-medium rounded-md shadow-sm hover:bg-primary-hover transition-colors"
                data-media-type="banani-button"
              >
                <span
                  data-file="/screens/InventoryManagement_copy1.jsx"
                  data-idx="50"
                  >Add to Inventory</span
                >
              </button>
            </div>
          </div>
        </div>
      </div>
    </body>
  </html>
  <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
</div>
