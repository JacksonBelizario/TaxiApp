<template>
  <v-app id="login">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar color="amber">
                <v-toolbar-title>Login</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person" v-model="email" label="email" type="email" color="grey darken-4"></v-text-field>
                  <v-text-field id="password" prepend-icon="lock" v-model="senha" label="senha" type="password" color="grey darken-4"></v-text-field>
                  <v-radio-group v-model="tipoUser" row>
                      <v-radio label="Cliente" value="cliente"></v-radio>
                      <v-radio label="Motorista" value="motorista"></v-radio>
                  </v-radio-group>
                </v-form>
                <v-alert :value="true" type="error" v-if="error"><span v-html="error"></span></v-alert>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="amber" @click="login">Login</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  export default {
    name: "Login",
    data: () => ({
      tipoUser: 'cliente',
      email: "",
      senha: "",
      error: false,
    }),
    updated() {
      if (localStorage.token) {
        this.$router.replace(this.$route.query.redirect || '/home')
      }
    },
    methods: {
      login () {
        this.$http.post(`/${this.tipoUser}/auth`, { email: this.email, senha: this.senha })
          .then(({data}) => this.loginSuccessful(data))
          .catch(({response}) => this.loginFailed(response))
      },
      loginSuccessful (data) {
        this.error = false
        localStorage.token = data.token;
        this.$router.replace(this.$route.query.redirect || '/home')
      },
      loginFailed (err) {
        let erros;
        if (typeof err.data === 'object') {
          if (err.data.hasOwnProperty("error")) {
            erros = [err.data.error];
          } else {
            erros = Object.keys(err.data).map(item => `<b>${item}:</b> ${err.data[item][0]}`);
          }
        } else {
          erros = [JSON.stringify(err.data)];
        }

        this.error = `Falha ao logar!<br>${erros.join("<br>")}`
        delete localStorage.token
      }
    }
  }
</script>
