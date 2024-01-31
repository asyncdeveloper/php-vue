<template>
  <div class='min-h-screen justify-center flex mt-10 '>
    <div class='w-8/12'>

      <h1 class='text-5xl mb-12'>List of Subscribers</h1>

      <button class='mb-12 bg-blue-500 text-white px-4 py-4' @click='renderPopUp'>
        Add New Subscriber
      </button>

      <SubscriberTable :data='data' :meta='meta' @page-change='updatePage' @show-subscriber='showSubscriber' />

      <div v-if='renderAddPopUp' class='fixed inset-0 z-10 overflow-y-auto'>
        <div class='absolute inset-0 bg-black opacity-50 z-20'></div>
        <div class='flex items-center justify-center min-h-screen'>
          <div class='bg-white p-6 rounded shadow-md w-1/2 relative z-30'>
            <h2 class='text-2xl font-bold mb-6'>Add a New Subscriber</h2>

            <div v-show='error' class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-5'
                 role='alert'>
              <strong class='font-bold'>Error! </strong>
              <span class='block sm:inline'>{{ error }}</span>
              <span class='absolute top-0 bottom-0 right-0 px-4 py-3' @click='error = null'>
                  <svg class='fill-current h-6 w-6 text-red-500' role='button' viewBox='0 0 20 20'
                       xmlns='http://www.w3.org/2000/svg'>
                    <title>Close</title>
                    <path
                      d='M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z' />
                  </svg>
                </span>
            </div>

            <form @submit.prevent='addNewSubscriber'>
              <label class='block mb-2'>Name:</label>
              <input v-model='newSubscriber.name' class='border p-2 w-full' />

              <label class='block mt-4 mb-2'>Last Name:</label>
              <input v-model='newSubscriber.last_name' class='border p-2 w-full' />

              <label class='block mt-4 mb-2'>Email:</label>
              <input v-model='newSubscriber.email' class='border p-2 w-full' type='email' />

              <label class='block mt-4 mb-2'>Status:</label>
              <select v-model.number='newSubscriber.status' class='border p-2 w-full'>
                <option selected value='active'>Active</option>
                <option value='in_active'>Inactive</option>
              </select>

              <div class='mt-8'>
                <button class='bg-green-500 text-white px-4 py-2 rounded' type='submit'>Add</button>
                <button class='ml-2 bg-gray-500 text-white px-4 py-2 rounded' @click='closePopUp'>Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div v-if='renderViewPopUp' class='fixed inset-0 z-10 overflow-y-auto'>
        <div class='absolute inset-0 bg-black opacity-50 z-20'></div>
        <div class='flex items-center justify-center min-h-screen'>
          <div class='bg-white p-6 rounded shadow-md w-1/2 relative z-30'>
            <h2 class='text-2xl font-bold mb-4'>Subscriber</h2>
            <label class='block mb-2'>Name: {{ currentSubscriber.name }}</label>
            <label class='block mb-2'>Last Name: {{ currentSubscriber.last_name }}</label>
            <label class='block mb-2'>Email: {{ currentSubscriber.email }}</label>
            <label class='block mb-2'>Status: <span
              v-if='currentSubscriber.status !== null'> {{ currentSubscriber.status === 1 ? 'Active' : 'Inactive' }}</span></label>

            <div class='mt-4'>
              <button class='bg-gray-500 text-white px-4 py-2 rounded' @click='renderViewPopUp = false'>Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SubscriberTable from './components/SubscriberTable.vue'
import { createSubscriber, getPaginatedSubscribers, getSubscriber } from '@/api/subscription.js'

export default {
  components: {
    SubscriberTable
  },
  data() {
    return {
      data: [],
      renderAddPopUp: false,
      renderViewPopUp: false,
      error: '',
      currentSubscriber: {
        id: '',
        name: '',
        last_name: '',
        email: '',
        status: ''
      },
      meta: {
        total: 0,
        page: 1,
        limit: 5
      },
      newSubscriber: {
        name: '',
        last_name: '',
        email: '',
        status: 'active'
      }
    }
  },
  mounted() {
    this.getSubscribers()
  },
  methods: {
    async getSubscribers() {
      try {
        const { data, ...others } = await getPaginatedSubscribers({ ...this.meta })
        const meta = { ...others, total_pages: others.total / others.per_page }

        this.data = data
        this.meta = meta
      } catch (error) {
        console.error('Error getSubscribers', error)
      }
    },

    closePopUp() {
      this.renderAddPopUp = false
      this.resetForm()
    },

    renderPopUp() {
      this.renderAddPopUp = true
    },

    resetForm() {
      this.newSubscriber = {
        name: '',
        last_name: '',
        email: '',
        status: null
      }

      this.error = ''
    },

    async addNewSubscriber() {
      try {
        await createSubscriber(this.newSubscriber)

        location.reload()
      } catch (error) {
        this.error = error.response.data.message
      }
    },

    async showSubscriber(id) {
      try {
        const data = await getSubscriber(id)
        this.currentSubscriber = data.data

        this.renderViewPopUp = true
      } catch (error) {
        console.error('Error fetching currentSubscriber:', error)
      }
    },

    async updatePage(pageNumber) {
      this.meta.page = pageNumber
      await this.getSubscribers()
    }
  }
}
</script>
