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

      <!-- formulario buscar -->
      <form>
        <div class="w3-col m7 l8">
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

    <hr />
    <!-- mensaje de respuesta -->
    <div v-if="message" class="w3-panel w3-pale-blue w3-display-container">
      <span v-on:click="limpiar_mensajes()" class="w3-button w3-large w3-display-topright">&times;</span>
      <p>
        {{ message }}
      </p>
    </div>

    <!-- listado de clientes -->
    <h2>Clientes Registrados</h2>
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
              <button class="w3-button w3-highway-red" v-on:click="eliminar(item)"> Eliminar </button>
          </td>
        </tr>
      </table>
    </div>

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
          <div v-if="error" class="w3-panel w3-red w3-display-container">
            <p>{{ error }}</p>
          </div>

          <form v-on:submit.prevent="create()">
            <p>
              <input v-model="numero_documento" class="w3-input w3-border" maxlength="50" type="text"
                placeholder="Número Documento " required />
            </p>
            <p>
              <input v-model="nombre" class="w3-input w3-border" type="text" maxlength="50" placeholder="Nombre"
                required />
            </p>
            <p>
              <input v-model="apellidos" class="w3-input w3-border" type="text" maxlength="50" placeholder="Apellidos"
                required />
            </p>
            <h4>Datos del vehículo</h4>
            <p>
              <input v-model="placa" class="w3-input w3-border" type="text" maxlength="50" placeholder="Placa - Serial"
                required />
            </p>

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
          <div v-if="error" class="w3-panel w3-red w3-display-container">
            <p>{{ error }}</p>
          </div>
          <div v-if="loading" class="w3-panel w3-blue w3-display-container">
            <p>Loading...</p>
          </div>
          <form v-on:submit.prevent="update()">
            <label for="numero_documento">Número de documento </label>
            <p>
              <input v-model="numero_documento" class="w3-input w3-border" maxlength="50" type="text"
                placeholder="Número Documento " required id="numero_documento" />
            </p>
            <label for="nombre">Nombre</label>
            <p>
              <input v-model="nombre" class="w3-input w3-border" type="text" maxlength="50" placeholder="Nombre"
                required id="nombre" />
            </p>
            <label for="apellidos">Apellidos</label>
            <p>
              <input v-model="apellidos" class="w3-input w3-border" type="text" maxlength="50" placeholder="Apellidos"
                required id="apellidos" />
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
          <div v-if="error" class="w3-panel w3-red w3-display-container">
            <p>{{ error }}</p>
          </div>
          <form v-on:submit.prevent="agregar_vehiculo()">
            <p>
              <input v-model="placa" class="w3-input w3-border" type="text" maxlength="50" placeholder="Placa - Serial"
                required />
            </p>

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
          <div v-if="loading" class="w3-panel w3-blue w3-display-container">
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
        error: false,
        loading: false,
        saving: false,
        message: false,
      };
    },
    created() {
      this.listar();
    },
    methods: {
      listar() {
        this.error = this.users = null;
        this.loading = true;
        axios
          .get("/api/clientes")
          .then((response) => {
            this.loading = false;
            this.clientes = response.data.data;
          })
          .catch((error) => {
            this.loading = false;
            this.error = error.response.data.message || error.message;
          });
      },
      create($event) {
        this.saving = true;
        this.message = false;
        let datos = {
          numero_documento: this.numero_documento,
          nombre: this.nombre,
          apellidos: this.apellidos,
          placa: this.placa.toUpperCase(),
          tipo: this.tipo,
        };
        api_cliente
          .create(datos)
          .then(() => {
            this.message = "Cliente registrado con éxito";
            this.error = false;
            this.cancelar();
          })
          .catch((e) => {
            this.error =
              e.response.data.message || "Hubo un problema al crear el cliente.";
          })
          .then(() => (this.saving = false));
      },
      update($event) {
        this.saving = true;
        this.message = false;
        this.error = false;
        let datos = {
          numero_documento: this.numero_documento,
          nombre: this.nombre,
          apellidos: this.apellidos,
        };
        api_cliente
          .update(this.id, datos)
          .then(() => {
            this.message = "Cliente actualizado con éxito";
            this.cancelar();
          })
          .catch((e) => {
            this.error =
              e.response.data.message ||
              "Hubo un problema al actualizar el cliente.";
          })
          .then(() => (this.saving = false));
      },
      eliminar(objeto) {
        this.saving = true;
        api_cliente.delete(objeto.id).then((response) => {
          this.message = "Cliente Deleted";
          this.listar();
        }).catch((e) => {
            this.message = e.response.data.message || "Hubo un problema al cargar los datos.";
          });;
      },
      abrirModalEditar(objeto) {
        document.getElementById("id02").style.display = "block";
        this.loading = true;
        this.id = objeto.id;
        api_cliente
          .find(this.id)
          .then((response) => {
            this.loading = false;
            //cargar los datos
            this.numero_documento = response.data.data.numero_documento;
            this.nombre = response.data.data.nombre;
            this.apellidos = response.data.data.apellidos;
          })
          .catch((e) => {
            this.error =
              e.response.data.message || "Hubo un problema al cargar los datos.";
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
        api_vehiculo
          .create(datos)
          .then(() => {
            this.message = "Vehiculo registrado con éxito";
            this.error = false;
            this.cancelar();
          })
          .catch((e) => {
            this.error =
              e.response.data.message || "Hubo un problema al crear el vehiculo.";
          })
          .then(() => (this.saving = false));
      },
      abrirModalVerVehiculo(objeto) {
        document.getElementById("id04").style.display = "block";
        this.loading = true;
        this.id = objeto.id;
        api_vehiculo
          .find_cliente(this.id)
          .then((response) => {
            this.loading = false;
            this.vehiculos = response.data.data;
          })
          .catch((e) => {
            this.error =
              e.response.data.message || "Hubo un problema al cargar los datos.";
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
        this.error = false;
        this.loading = false;
        this.saving = false;
        this.message = false;
      },
    },
  };
</script>