document.addEventListener('DOMContentLoaded', () => {
    const formOverlay = document.getElementById('modal-login');
    const form = document.getElementById('login-form');


    if(sessionStorage.getItem('authToken')){
    (async () => {            
            const tokenStatus = await postApi('/api/loginCheck', {token: sessionStorage.getItem('authToken')});
            if(tokenStatus.status == 1){
                formOverlay.style.display = 'none';
            }
            else{
                formOverlay.style.display = 'flex';
            }
            })();
        }
    else{
        formOverlay.style.display = 'flex';
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const login = document.getElementById('login-input').value;
        const password = document.getElementById('password-input').value;
        
        const hashedPassword = sha512(password);
        //const hashedPassword = await hashSHA512(password);
        
        const dataToSend = {
            login: login,
            password_hash: hashedPassword
        };

        

        try {

            const token = await postApi('/api/login', dataToSend);

            if (token.token !== '') {
                sessionStorage.setItem('authToken', token.token)
                location.reload();
            } else {
                alert('Невірний логін або пароль.');
            }

        } catch (error) {
            console.error('Помилка:', error);
        }
    });
});

