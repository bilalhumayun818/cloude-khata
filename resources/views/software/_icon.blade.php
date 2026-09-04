@switch($icon)
    @case('cloud')
        <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M10.2 24.5H8.5a5.5 5.5 0 0 1-.6-11A8.5 8.5 0 0 1 24.2 12a6.3 6.3 0 0 1-.7 12.5h-2.1"/><path d="M11.5 20.5 16 25l4.5-4.5M16 14.5V25"/></svg>
        @break
    @case('store')
        <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M5 13h22l-2.7-7H7.7L5 13Z"/><path d="M7 13v13h18V13M12 26v-7h8v7M5 13c0 2 1.2 3 3 3s3-1 3-3c0 2 1.2 3 3 3s3-1 3-3c0 2 1.2 3 3 3s3-1 3-3c0 2 1.2 3 3 3s3-1 3-3"/></svg>
        @break
    @case('courier')
        <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M4 8h15v15H4zM19 13h5l4 5v5h-9z"/><circle cx="9" cy="24" r="2.5"/><circle cx="23" cy="24" r="2.5"/><path d="M7 12h8M7 16h6"/></svg>
        @break
    @case('orders')
        <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M10 6h17v20H10zM5 10h5M5 16h5M5 22h5"/><path d="m14 12 1.5 1.5L19 10m-5 9 1.5 1.5L19 17m3-5h2m-2 7h2"/></svg>
        @break
    @case('restaurant')
        <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M9 5v8m-4-8v6a4 4 0 0 0 8 0V5M9 15v12M22 5c-3 2-4 5-4 9h7V5h-3ZM22 14v13"/></svg>
        @break
    @default
        <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M9 24 23 8M8 20c-3 3-3 6-1 7s5 0 7-3M24 12c3-3 3-6 1-7s-5 0-7 3"/><path d="M11 21c2 2 6 2 10 0M12 11c4-2 8-1 10 1"/></svg>
@endswitch
