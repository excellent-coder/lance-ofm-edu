<modal title="Login To continue" btn-txt="Login" id="login-modal" :visible="false">
    <template v-slot:body>
        <login></login>
    </template>
</modal>

<modal title="Register To continue" btn-txt="Register" id="register-modal" :visible="false">
    <template v-slot:body>
        <sign-up></sign-up>
    </template>
</modal>
<modal title="Enter Your Email To reset Password" btn-txt="Reset Password" id="reset-password-modal" :visible="false">
    <template v-slot:body>
        <reset-password></reset-password>
    </template>
</modal>
