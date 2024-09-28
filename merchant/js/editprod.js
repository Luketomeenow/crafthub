document.addEventListener("DOMContentLoaded", function () {
    const colorContainer = document.getElementById('color-container');
    const sizeContainer = document.getElementById('size-container');
    const priceContainer = document.getElementById('price-container');
    const addColorButton = document.getElementById('add-color');
    const addSizePriceButton = document.getElementById('add-size-price');

    // Helper function to add new input fields
    function createInput(type, name, placeholder) {
        const input = document.createElement('input');
        input.type = type;
        input.name = name;
        input.placeholder = placeholder;
        input.classList.add('form-control');
        return input;
    }

    // Generic function to add a new input group with a remove button
    function createInputGroup(container, name, placeholder, removeClass) {
        const inputGroup = document.createElement('div');
        inputGroup.classList.add('input-group', 'mt-2');
        inputGroup.appendChild(createInput('text', name, placeholder));

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.classList.add('btn', 'btn-danger', removeClass);
        removeBtn.textContent = 'Remove';
        inputGroup.appendChild(removeBtn);

        container.appendChild(inputGroup);

        removeBtn.addEventListener('click', function () {
            container.removeChild(inputGroup);
        });
    }

    // Add a new color input field
    addColorButton.addEventListener('click', function () {
        createInputGroup(colorContainer, 'color[]', 'Color', 'remove-color');
    });

    // Add new size and price input fields
    addSizePriceButton.addEventListener('click', function () {
        createInputGroup(sizeContainer, 'size[]', 'Size', ' ');
        createInputGroup(priceContainer, 'price[]', 'Price', 'remove-size-price');
    });

    // Event delegation for dynamically created remove buttons
    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("remove-color")) {
            var colorId = event.target.parentNode.getAttribute('data-color-id');
            if (colorId) {
                fetch('delete_color.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: colorId })
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        event.target.parentNode.remove();
                    } else {
                        alert('Failed to remove color.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('Failed to remove color.');
                });
            } else {
                event.target.parentNode.remove();
            }
        } else if (event.target.classList.contains("remove-size-prize")) {
            var sizeId = event.target.parentNode.getAttribute('data-size-id');
            if (sizeId) {
                fetch('delete_size.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: sizeId })
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        event.target.parentNode.remove();
                    } else {
                        alert('Failed to remove size.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('Failed to remove size.');
                });
            } else {
                event.target.parentNode.remove();
            }
        }
    });

    // Function to handle removal with server interaction
    function handleRemove(event, url) {
        const parentDiv = event.target.parentNode;
        const id = parentDiv.getAttribute('data-id');
        
        if (id) {
            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        parentDiv.remove();
                    } else {
                        alert('Failed to remove item.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('Failed to remove item.');
                });
        } else {
            parentDiv.remove();
        }
    }
    
});
