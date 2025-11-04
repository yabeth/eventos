document.addEventListener('DOMContentLoaded', (event) => {
    const comboBox = document.createElement('select');
    comboBox.id = 'comboBox';
    const option1 = document.createElement('option');
    option1.value = '1';
    option1.text = 'Opción 1';
    comboBox.add(option1);
    const option2 = document.createElement('option');
    option2.value = '2';
    option2.text = 'Opción 2';
    comboBox.add(option2);

    const label = document.createElement('label');
    label.id = 'elieven';
    label.textContent = 'Ninguno';

    document.body.appendChild(comboBox);
    document.body.appendChild(label);

    comboBox.addEventListener('change', function() {
        const selectedOption = comboBox.options[comboBox.selectedIndex];
        label.textContent = selectedOption.text;
    });
});