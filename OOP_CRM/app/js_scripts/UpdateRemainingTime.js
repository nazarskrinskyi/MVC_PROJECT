function updateRemainingTime() {
    const dueDateElements = document.querySelectorAll('.due-date');
    const now = new Date();

    dueDateElements.forEach((element) => {
        const dueDate = new Date(element.textContent);
        const timeDiff = dueDate - now;

        if (timeDiff > 0) {
            const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));

            element.textContent = `Days: ${days} Hours: ${hours}`;
        } else {
            element.textContent = 'Time is up';
        }
    });
}

updateRemainingTime();
setInterval(updateRemainingTime, 60000); // Update every minute