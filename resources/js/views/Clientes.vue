<template>
   <div>
      <!-- nuevo cliente -->
      <div class="w3-row">
         <div class="w3-col m4 l3">
            <div class="btn_nuevo">
               <button onclick="document.getElementById('id01').style.display = 'block'" class="w3-button w3-blue">
                  + Nuevo Cliente
               </button>
            </div>
         </div>


      </div>

      <hr />
      <!-- mensaje de respuesta -->
      <div v-if="message" class="w3-panel w3-pale-blue w3-display-container">
         <span v-on:click="cerrar()" class="w3-button w3-large w3-display-topright">&times;</span>
         <p>
            {{ message }}
         </p>
      </div>

      <!-- leyendo informacion  -->
      <div v-if="loading_listar" class="w3-panel w3-pale-green w3-display-container">
         <p>Loading...</p>
      </div>

      <!-- mensaje de error-->
      <div v-if="error" class="w3-panel w3-pale-red w3-display-container">
         <span v-on:click="cerrar()" class="w3-button w3-large w3-display-topright">&times;</span>
         <p>{{ error }}</p>
      </div>

      <!-- buscador -->
      <div class="w3-row">
         <div class="w3-col m4 l3">
            <h2>Clientes Registrados</h2>
         </div>
         <div class="w3-col m4 l4">
            <p></p>
         </div>
         <div class="w3-col m4 l4">
            <!-- formulario buscar -->
            <form>
               <div class="w3-col m11 l11">
                  <div>
                     <input class="w3-input w3-border" value="" type="search" name="buscar" />
                  </div>
               </div>
               <div class="w3-col m1 l1">
                  <div>
                     <button type="submit" class="w3-button w3-border w3-blue">
                        Buscar
                     </button>
                  </div>
               </div>
            </form>
         </div>
      </div>

      <!-- listado de clientes -->
      <div class="w3-responsive w3-margin-bottom">
         <table class="w3-table-all">
            <tr class="w3-dark-grey">
               <th>Número documento</th>
               <th>Nombre</th>
               <th>Apellidos</th>
               <th>Editar</th>
               <th>Agregar Vehículo</th>
               <th>Vehículos</th>
               <th>Eliminar</th>
            </tr>

            <tr v-for="item in clientes" :key="item.id">
               <td>{{ item.numero_documento }}</td>
               <td>{{ item.nombre }}</td>
               <td>{{ item.apellidos }}</td>
               <td>
                  <button class="w3-button w3-highway-blue" v-on:click="abrirModalEditar(item)">
                     Editar
                  </button>
               </td>
               <td>
                  <button class="w3-button w3-highway-orange" v-on:click="abrirModalAgregarVehiculo(item)">
                     Agregar vehículo
                  </button>
               </td>
               <td>
                  <button class="w3-button w3-highway-green" v-on:click="abrirModalVerVehiculo(item)">
                     Ver
                  </button>
               </td>
               <td>
                  <button class="w3-button w3-highway-red" v-on:click="eliminar(item)">
                     Eliminar
                  </button>
               </td>
            </tr>
         </table>
      </div>

      <!-- paginacion -->
      <div class="w3-right">
         <div class="w3-bar">
            <a href="#" class="w3-button">&laquo;</a>
            <a href="#" class="w3-button w3-blue">1</a>
            <a href="#" class="w3-button">2</a>
            <a href="#" class="w3-button">3</a>
            <a href="#" class="w3-button">4</a>
            <a href="#" class="w3-button">&raquo;</a>
         </div>
      </div>

      <!-- Modal Nuevo  -->
      <div id="id01" class="w3-modal">
         <div class="w3-modal-content">
            <header class="w3-container w3-light-grey">
               <span v-on:click="cerrar()" class="w3-button w3-display-topright">&times;</span>
               <h2>Nuevo Cliente</h2>
            </header>

            <div class="w3-container">


               <!-- formulario -->
               <form v-on:submit.prevent="create()">
                  <p>
                     <input v-model="numero_documento" v-bind:class="{'w3-border-red': error_numero_documento}"
                        class="w3-input w3-border" type="text" maxlength="50" placeholder="Número Documento "
                        required />
                  </p>
                  <p v-if="error_numero_documento" class="w3-text-red">{{ error_numero_documento }}</p>
                  <p>
                     <input v-model="nombre" class="w3-input w3-border" type="text" maxlength="50" placeholder="Nombre"
                        required />
                  </p>
                  <p>
                     <input v-model="apellidos" class="w3-input w3-border" type="text" maxlength="50"
                        placeholder="Apellidos" required />
                  </p>
                  <h4>Datos del vehículo</h4>
                  <p>
                     <input v-model="placa" v-bind:class="{'w3-border-red': error_placa}" class="w3-input w3-border"
                        type="text" maxlength="50" placeholder="Placa - Serial" required />
                  </p>
                  <p v-if="error_placa" class="w3-text-red">{{ error_placa }}</p>

                  <p>
                     <select class="w3-select w3-border" required v-model="tipo">
                        <option value="" disabled selected>Tipo</option>
                        <option value="Automovil">Automóvil</option>
                        <option value="Moto">Moto</option>
                        <option value="Bicicleta">Bicicleta</option>
                     </select>
                  </p>

                  <p>
                     <button class="w3-button w3-blue w3-padding-large" :disabled="saving" type="submit">
                        {{ saving ? "Guardando..." : "Guardar" }}
                     </button>
                  </p>
               </form>
            </div>
         </div>
      </div>

      <!-- Modal Editar  -->
      <div id="id02" class="w3-modal">
         <div class="w3-modal-content">
            <header class="w3-container w3-light-grey">
               <span v-on:click="cerrar()" class="w3-button w3-display-topright">&times;</span>
               <h2>Editar Cliente</h2>
            </header>

            <div class="w3-container">

               <!-- leyendo informacion -->
               <div v-if="loading" class="w3-panel w3-pale-green w3-display-container">
                  <p>Loading...</p>
               </div>


               <!-- formulario -->
               <form v-on:submit.prevent="update()">
                  <label for="numero_documento">Número de documento </label>
                  <p>
                     <input v-model="numero_documento" v-bind:class="{'w3-border-red': error_numero_documento}"
                        class="w3-input w3-border" maxlength="50" type="text" placeholder="Número Documento " required
                        id="numero_documento" />
                  </p>
                  <p v-if="error_numero_documento" class="w3-text-red">{{ error_numero_documento }}</p>
                  <label for="nombre">Nombre</label>
                  <p>
                     <input v-model="nombre" class="w3-input w3-border" type="text" maxlength="50" placeholder="Nombre"
                        required id="nombre" />
                  </p>
                  <label for="apellidos">Apellidos</label>
                  <p>
                     <input v-model="apellidos" class="w3-input w3-border" type="text" maxlength="50"
                        placeholder="Apellidos" required id="apellidos" />
                  </p>
                  <p>
                     <button class="w3-button w3-blue w3-padding-large" :disabled="saving" type="submit">
                        {{ saving ? "Guardando..." : "Guardar" }}
                     </button>
                  </p>
               </form>

            </div>
         </div>
      </div>

      <!-- Modal agregar vehiculo  -->
      <div id="id03" class="w3-modal">
         <div class="w3-modal-content">
            <header class="w3-container w3-light-grey">
               <span v-on:click="cerrar()" class="w3-button w3-display-topright">&times;</span>
               <h3>Datos del vehículo</h3>
            </header>
            <div class="w3-container">

               <form v-on:submit.prevent="agregar_vehiculo()">
                  <p>
                     <input v-model="placa" v-bind:class="{'w3-border-red': error_placa}" class="w3-input w3-border "
                        type="text" maxlength="50" placeholder="Placa - Serial" required />
                  </p>
                  <p v-if="error_placa" class="w3-text-red">{{ error_placa }}</p>

                  <p>
                     <select class="w3-select w3-border" required v-model="tipo">
                        <option value="" disabled selected>Tipo</option>
                        <option value="Automovil">Automóvil</option>
                        <option value="Moto">Moto</option>
                        <option value="Bicicleta">Bicicleta</option>
                     </select>
                  </p>

                  <p>
                     <button class="w3-button w3-blue w3-padding-large" :disabled="saving" type="submit">
                        {{ saving ? "Guardando..." : "Guardar" }}
                     </button>
                  </p>
               </form>
            </div>
         </div>
      </div>

      <!-- modal ver vehiculos -->
      <div id="id04" class="w3-modal">
         <div class="w3-modal-content">
            <header class="w3-container w3-light-grey">
               <span v-on:click="cerrar()" class="w3-button w3-display-topright">&times;</span>
               <h2>Vehículos del Cliente</h2>
            </header>

            <div class="w3-container">
               <div v-if="loading" class="w3-panel w3-pale-green w3-display-container">
                  <p>Loading...</p>
               </div>

               <div class="w3-responsive">
                  <table class="w3-table-all">
                     <tr class="w3-dark-grey">
                        <th>Placa</th>
                        <th>Tipo</th>
                     </tr>
                     <tr v-for="item in vehiculos" :key="item.id">
                        <td>{{ item.placa }}</td>
                        <td>{{ item.tipo }}</td>
                     </tr>
                  </table>
               </div>
            </div>
            <br />
            <br />
         </div>
      </div>
   </div>
</template>

<script>
   import api_cliente from "../api/clientes.js";
   import api_vehiculo from "../api/vehiculos.js";

   export default {
      data() {
         return {
            //cliente
            id: "",
            numero_documento: "",
            nombre: "",
            apellidos: "",
            clientes: [],
            //datos vehiculo
            placa: "",
            tipo: "",
            cliente_id: "",
            vehiculos: [],
            //mensajes
            message: false,
            error: false,
            loading: false,
            saving: false,
            loading_listar: false,
            error_numero_documento: false,
            error_placa: false,
         };
      },
      created() {
         this.listar();
      },
      methods: {
         listar() {
            this.loading_listar = true;
            axios.get("/api/clientes?api_token=" + localStorage.getItem('token'))
               .then((response) => {
                  this.loading_listar = false;
                  this.clientes = response.data.data;
               })
               .catch((error) => {
                  this.loading_listar = false;
                  this.error = 'Error interno en el servidor, intente más tarde';
               });
         },
         create($event) {
            this.saving = true;

            let datos = {
               numero_documento: this.numero_documento,
               nombre: this.nombre,
               apellidos: this.apellidos,
               placa: this.placa.toUpperCase(),
               tipo: this.tipo,
            };

            axios.post("/api/clientes?api_token=" + localStorage.getItem('token'), datos)
               .then(() => {
                  this.cerrar();
                  this.message = "Cliente registrado con éxito";
                  this.listar();
               })
               .catch((error) => {
                  if (error.response.status == 422) {

                     if (error.response.data.errors.numero_documento != undefined) {
                        this.error_numero_documento = error.response.data.errors.numero_documento[0];
                     }

                     if (error.response.data.errors.placa != undefined) {
                        this.error_placa = error.response.data.errors.placa[0];
                     }
                  } else {
                     this.cerrar();
                     this.error = 'Error interno en el servidor, intente más tarde';
                  }

               })
               .then(() => (this.saving = false));
         },
         update($event) {
            this.saving = true;

            let datos = {
               numero_documento: this.numero_documento,
               nombre: this.nombre,
               apellidos: this.apellidos,
            };

            axios.put(`/api/clientes/${this.id}`+"?api_token=" + localStorage.getItem('token'), datos)
               .then(() => {
                  this.cerrar();
                  this.message = "Cliente actualizado con éxito";
                  this.listar();
               })
               .catch((error) => {
                  if (error.response.status == 422) {
                     if (error.response.data.errors.numero_documento != undefined) {
                        this.error_numero_documento = error.response.data.errors.numero_documento[0];
                     }
                  } else {
                     this.cerrar();
                     this.error = 'Error interno en el servidor, intente más tarde';
                  }

               })
               .then(() => (this.saving = false));
         },
         eliminar(objeto) {
            this.saving = true;
            this.id = objeto.id;
            axios.delete(`/api/clientes/${this.id}`+"?api_token=" + localStorage.getItem('token'))
               .then((response) => {
                  this.cerrar();
                  this.message = "Cliente eliminado con éxito";
                  this.listar();
               })
               .catch((error) => {
                  this.cerrar();
                  if (error.response.status == 403) {
                     this.error = error.response.data.message || "Hubo un problema al cargar los datos.";
                  } else {
                     this.error = 'Error interno en el servidor, intente más tarde';
                  }

               });
         },
         abrirModalEditar(objeto) {
            document.getElementById("id02").style.display = "block";
            this.limpiar_mensajes();
            this.loading = true;
            this.id = objeto.id;
            axios.get(`/api/clientes/${objeto.id}`+"?api_token=" + localStorage.getItem('token'))
               .then((response) => {
                  this.loading = false;
                  this.numero_documento = response.data.data.numero_documento;
                  this.nombre = response.data.data.nombre;
                  this.apellidos = response.data.data.apellidos;
               })
               .catch((e) => {
                  //this.error =   e.response.data.message || "Hubo un problema al cargar los datos.";
                  this.cerrar();
                  this.error = "Error interno en el servidor, intente más tarde"
               });
         },
         abrirModalAgregarVehiculo(objeto) {
            this.id = objeto.id;
            document.getElementById("id03").style.display = "block";
         },
         agregar_vehiculo() {
            this.saving = true;
            this.message = false;
            let datos = {
               placa: this.placa.toUpperCase(),
               tipo: this.tipo,
               cliente_id: this.id,
            };
            axios.post('/api/vehiculos', datos)           
               .then(() => {
                  this.cerrar();
                  this.message = "Vehículo registrado con éxito";
                  this.listar();
               })
               .catch((error) => {
                  if (error.response.status == 422) {
                     if (error.response.data.errors.placa != undefined) {
                        this.error_placa = error.response.data.errors.placa[0];
                     }
                  } else {
                     this.cerrar();
                     this.error = 'Error interno en el servidor, intente más tarde';
                  }
               })
               .then(() => (this.saving = false));
         },
         abrirModalVerVehiculo(objeto) {
            document.getElementById("id04").style.display = "block";
            this.loading = true;
            this.id = objeto.id;
            axios.get(`/api/vehiculos_cliente/${this.id}`)
               .then((response) => {
                  this.loading = false;
                  this.vehiculos = response.data.data;
               })
               .catch((error) => {
                  this.cerrar();
                  this.error = 'Error interno en el servidor, intente más tarde';
               });
         },
         cerrar: function () {
            this.cancelar();
            this.limpiar_mensajes();
         },
         cancelar: function () {
            //limpiar todos los campos
            this.id = "";
            this.numero_documento = "";
            this.nombre = "";
            this.apellidos = "";
            this.placa = "";
            this.tipo = "";
            this.cliente_id = "";
            //cerrar modales
            document.getElementById("id01").style.display = "none";
            document.getElementById("id02").style.display = "none";
            document.getElementById("id03").style.display = "none";
            document.getElementById("id04").style.display = "none";
         },
         limpiar_mensajes: function () {
            this.message = false;
            this.error = false;
            this.loading = false;
            this.saving = false;
            this.loading_listar = false
            this.error_numero_documento = false;
            this.error_placa = false;
         },
      },
   };
</script>