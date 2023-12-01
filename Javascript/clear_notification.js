function markAsViewed(event) {
    event.preventDefault(); 

    fetch('clear_notification.php', {
        method: 'POST',
        body: JSON.stringify({ status: 'viewed' }), 
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            
            console.log('Status updated to viewed');
        } else {
        
            console.error('Failed to update status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
