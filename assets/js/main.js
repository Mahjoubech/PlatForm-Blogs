document.getElementById("loginForm").addEventListener("submit", function(e) {


    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    // Validate input
    if (!email || !password) {
        alert("Please fill in all fields.");
        return;
    }
});

document.getElementById("createAccountForm").addEventListener("submit", function(e) {


    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    // Validate input
    if (!name || !email || !password || !confirmPassword) {
        alert("Please fill in all fields.");
        return;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return;
    }

});


document.addEventListener('DOMContentLoaded', () => {
    // Add event listeners for actions
    const actionButtons = document.querySelectorAll('button');
    actionButtons.forEach(button => {
        button.addEventListener('click', () => {
            alert(`${button.textContent} action clicked!`);
        });
    });

    // Example for a dynamic chart
    const ctx = document.getElementById('userChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March'],
            datasets: [{
                label: 'User Growth',
                data: [50, 75, 150],
                backgroundColor: ['#6366f1', '#3b82f6', '#34d399']
            }]
        }
    });
});


const addArticleBtn = document.querySelector('.add_article');
const articleForm = document.querySelector('.article_form');
addArticleBtn.addEventListener('click', () => {
    articleForm.classList.toggle('hidden');
});