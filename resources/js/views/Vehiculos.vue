<template>
  <div>
    <div class="w3-container">
      <!-- buscador -->
      <div class="w3-row">
        <div class="w3-col m4 l3">
          <p></p>
        </div>
        <form v-on:submit.prevent="buscar()">
          <div class="w3-col m7 l8">
            <div>
              <input class="w3-input w3-border" type="search" v-model="valor" name="" id="" />
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

      <h2>Vehículos Registrados</h2>
      <div class="w3-responsive">
        <table class="w3-table-all">
          <tr class="w3-dark-grey">
            <th>Placa - Serial</th>
            <th>Tipo</th>
            <th>Cliente</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </tr>
          <tr v-for="item in vehiculos" :key="item.id">
            <td>{{ item.placa }}</td>
            <td>{{ item.tipo }}</td>
            <td>{{ item.nombre }} {{ item.apellidos }}</td>
            <td>
              <button class="w3-button w3-highway-blue" v-on:click="abrirModalEditar(item)">Editar</button>
            </td>
            <td>
              <button class="w3-button w3-highway-red" v-on:click="eliminar(item)">Eliminar</button>
            </td>
          </tr>
        </table>
      </div>

      <!-- Modal Editar  -->
      <div id="id01" class="w3-modal">
        <div class="w3-modal-content">
          <header class="w3-container w3-light-grey">
            <span v-on:click="cerrar()" class="w3-button w3-display-topright">&times;</span>
            <h2>Editar vehículo</h2>
          </header>
          <div class="w3-container">
            <div v-if="error" class="w3-panel w3-red w3-display-container">
              <p>{{ error }}</p>
            </div>
            <div v-if="loading" class="w3-panel w3-blue w3-display-container">
              <p>Loading...</p>
            </div>
            <form v-on:submit.prevent="update()">
              <label for="placa">Placa</label>
              <p>
                <input v-model="placa" class="w3-input w3-border" type="text" maxlength="50"
                  placeholder="Placa - Serial" required id="placa" />
              </p>
              <label for="Tipo de vehiculo">Tipo de vehiculo</label>
              <p>
                <select class="w3-select w3-border" required v-model="tipo">
                  <option value="Automovil">Automóvil</option>
                  <option value="Moto">Moto</option>
                  <option value="Bicicleta">Bicicleta</option>
                </select>
              </p>
              <label for="Tipo de vehiculo">Propietario</label>
              <p>
                <select class="w3-select w3-border" required v-model="cliente_id">
                  <option v-for="item in clientes" v-bind:value="item.id">{{ item.nombre }} {{ item.apellidos }}
                  </option>
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
    </div>
  </div>
</template>

<script>
  import api_cliente from "../api/clientes.js";
  import api_vehiculo from "../api/vehiculos.js";

  export default {
    data: function () {
      return {
        //datos vehiculo
        id: "",
        placa: "",
        tipo: "",
        cliente_id: '',
        vehiculos: [],
        clientes: [],
        //buscador
        valor: "",
        //mensajes
        error: false,
        loading: false,
        saving: false,
        message: false,
      };
    },
    created: function () {
      this.listar();
    },
    methods: {
      listar: function () {
        api_vehiculo
          .all()
          .then((response) => {
            this.vehiculos = response.data.data;
          })
          .catch((e) => {
            console.log(
              e.response.data.message || "Hubo un problema al cargar los datos."
            );
          });
      },
      buscar: function () {
        var config = {
          headers: {
            "Content-type": "application/x-www-form-urlencoded",
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        };

        axios
          .get(url_api + "vehiculos.php?buscar=" + this.valor, config)
          .then((response) => {
            if (response.data.status === "success") {
              this.vehiculos = response.data.datos;
            } else {
              console.log(response.data.mensaje);
            }
          })
          .catch((error) => {
            console.log(error);
          });
      },
      update($event) {
        this.saving = true;
        this.message = false;
        this.error = false;
        let datos = {
          placa: this.placa.toUpperCase(),
          tipo: this.tipo,
          cliente_id: this.cliente_id,
        };
        api_vehiculo
          .update(this.id, datos)
          .then(() => {
            this.message = "Vehiculo actualizado con éxito";
            this.cancelar();
            this.listar();
          })
          .catch((e) => {
            this.error = e.response.data.message || "Hubo un problema al actualizar el cliente.";
          })
          .then(() => (this.saving = false));
      },
      eliminar: function (objeto) {
        this.saving = true;
        api_vehiculo.delete(objeto.id).then((response) => {
          this.message = "Vehiculo Deleted";
          this.listar();
        });
      },
      cancelar: function () {
        //limpiar todos los campos
        this.id = "";
        this.placa = "";
        this.tipo = "";
        //cerrar modales
        document.getElementById("id01").style.display = "none";
      },
      abrirModalEditar(objeto) {
        document.getElementById("id01").style.display = "block";
        this.loading = true;
        this.id = objeto.id;
        this.cliente_id = objeto.cliente_id;
        api_vehiculo
          .find(this.id)
          .then((response) => {
            //cargar los datos
            this.placa = response.data.data.placa;
            this.tipo = response.data.data.tipo;
            this.cliente_id = response.data.data.cliente_id;
          })
          .catch((e) => {
            this.error = e.response.data.message || "Hubo un problema al cargar los datos.";
          });
        api_cliente
          .listar()
          .then((response) => {
            //cargar los datos
            this.loading = false;
            this.clientes = response.data.data;
          })
          .catch((e) => {
            this.error = e.response.data.message || "Hubo un problema al cargar los datos.";
          });
      },
      cerrar: function () {
        this.cancelar();
        this.limpiar_mensajes();
      },
      cancelar: function () {
        //limpiar todos los campos
        this.id = "";
        this.placa = "";
        this.tipo = "";
        this.cliente_id = "";
        //cerrar modales
        document.getElementById("id01").style.display = "none";
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

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>