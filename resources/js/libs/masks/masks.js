const onlyDigits = (value, maxLength) => {
    let v = value.replace(/\D/g, '');
    return maxLength ? v.slice(0, maxLength) : v;
};

const applyPattern = (value, pattern) => {
    let i = 0;
    return pattern.replace(/#/g, () => value[i++] || '');
};

const maskCPF = (e) => {
    let value = onlyDigits(e.target.value, 11);
    if (value) value = applyPattern(value, '###.###.###-##');

    e.target.value = value;
};

const maskCNPJ = (e) => {
    let value = onlyDigits(e.target.value, 14);
    if (value) value = applyPattern(value, '##.###.###/####-##');

    e.target.value = value;
};

const maskCEP = (e) => {
    let value = onlyDigits(e.target.value, 8);
    if (value.length > 5) value = applyPattern(value, '#####-###');

    e.target.value = value;
};

const maskDate = (e) => {
    let value = onlyDigits(e.target.value, 8);
    if (value.length > 4) value = applyPattern(value, '##/##/####');
    else if (value.length > 2) value = applyPattern(value, '##/##');

    e.target.value = value;
};

const maskPhone = (e) => {
    let value = onlyDigits(e.target.value, 11);
    if (value.length > 10) value = applyPattern(value, '(##) #####-####');
    else if (value.length > 6) value = applyPattern(value, '(##) ####-####');
    else if (value.length > 2) value = applyPattern(value, '(##) ####');
    else if (value.length > 0) value = applyPattern(value, '(##');

    e.target.value = value;
};

const maskMoney = (e) => {
    let value = onlyDigits(e.target.value);
    if (!value) {
        e.target.value = '';

        return;
    }
    value = (parseInt(value, 10) / 100).toFixed(2);
    value = value.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    e.target.value = 'R$ ' + value;
};

const maskDispatcher = {
    cpf: maskCPF,
    cnpj: maskCNPJ,
    cep: maskCEP,
    date: maskDate,
    phone: maskPhone,
    money: maskMoney,
};

export default {
    maskDispatcher, ...maskDispatcher,
};
