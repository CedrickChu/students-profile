document.addEventListener('DOMContentLoaded', function() {
    const themeToggleBtns = document.querySelectorAll('#theme-toggle');

    const theme = localStorage.getItem('theme');
    theme && document.body.classList.add(theme);

    const studentTable = document.getElementById("data-table");
    const initialTableTheme = localStorage.getItem('tableTheme');

    if (initialTableTheme) {
        studentTable.classList.toggle("table-dark", initialTableTheme === 'table-dark');
    }

    const handleThemeToggle = () => {
        document.body.classList.toggle('light-mode');
        if (document.body.classList.contains('light-mode')) {
            localStorage.setItem('theme', 'light-mode');
        } else {
            localStorage.removeItem('theme');
            document.body.classList.remove('light-mode');
        }

        if (studentTable) {
            studentTable.classList.toggle("table-dark");

            const isTableDark = studentTable.classList.contains("table-dark");
            localStorage.setItem('tableTheme', isTableDark ? 'table-dark' : 'table-light');
        }
    };

    themeToggleBtns.forEach(btn =>
        btn.addEventListener('click', handleThemeToggle)
    );
});
