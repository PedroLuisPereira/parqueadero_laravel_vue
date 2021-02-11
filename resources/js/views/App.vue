<template>
  <div>
    <!-- Navigation Bar -->
    <div class="w3-bar w3-light-grey w3-large menu">
      <a href="" class="w3-bar-item w3-button w3-dark-grey w3-mobile"
        >Parqueadero</a
      >
      <router-link :to="{ name: 'clientes' }" class="w3-bar-item w3-button w3-mobile" >Clientes</router-link>
      <router-link :to="{ name: 'vehiculos' }" class="w3-bar-item w3-button w3-mobile" >Vehículos</router-link>
      
      <a href="" class="w3-bar-item w3-button w3-mobile">Servicios</a>
      <a href="" class="w3-bar-item w3-button w3-mobile">Tarifas</a>
      <a href="" class="w3-bar-item w3-button w3-mobile">Usuarios</a>
      <a href="" class="w3-bar-item w3-button w3-right w3-mobile">Cuenta</a>
    </div>

    <!-- <p>
      <router-link :to="{ name: 'home' }">Home</router-link> |
      <router-link :to="{ name: 'hello' }">Hello World</router-link> |
      <router-link :to="{ name: 'users.index' }">Users</router-link>
    </p> -->

    <div class="contenido">
      <router-view></router-view>
    </div>
  </div>
</template>


<script>
export default {
  mounted() {
    //console.log('App componente')
  },
};
</script>
