document.addEventListener('DOMContentLoaded', function() {
    const themeToggleBtns = document.querySelectorAll('#theme-toggle');

    themeToggleBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            document.body.classList.toggle('light-mode');

            // Corrected: Get the element by ID and toggle the 'table-dark' class
            var studentTable = document.getElementById("student-table");
            if (studentTable) {
                studentTable.classList.toggle("table-dark");
            }
        });
    })
});