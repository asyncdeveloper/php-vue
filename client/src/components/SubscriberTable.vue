<template>

  <div v-if='data.length' class='mt-6'>
    <table class='min-w-full border border-gray-200'>

      <thead>
      <tr>
        <th class='py-2 px-4 border-b text-left'>ID</th>
        <th class='py-2 px-4 border-b text-left'>Name</th>
        <th class='py-2 px-4 border-b text-left'>Last Name</th>
        <th class='py-2 px-4 border-b text-left'>Email</th>
        <th class='py-2 px-4 border-b text-left'>Status</th>
        <th class='py-2 px-4 border-b text-left'>Actions</th>
      </tr>
      </thead>

      <tbody>
      <tr v-for='subscriber in data' :key='subscriber.id'>
        <td class='py-2 px-4 border-b'>{{ subscriber.id }}</td>
        <td class='py-2 px-4 border-b'>{{ subscriber.name }}</td>
        <td class='py-2 px-4 border-b'>{{ subscriber.last_name }}</td>
        <td class='py-2 px-4 border-b'>{{ subscriber.email }}</td>
        <td class='py-2 px-4 border-b'>{{ subscriber.status === 'active' ? 'Active' : 'Inactive' }}</td>
        <td class='py-2 px-4 border-b'>
          <button class='bg-blue-500 text-white px-4 py-2 rounded' @click="$emit('show-subscriber', subscriber.id)">
            View
          </button>
        </td>
      </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div v-if='meta.total_pages > 1' class='mt-6'>
      <button
        v-if='meta.page > 1'
        class='px-3 py-2 mx-1 border rounded hover:bg-gray-300'
        @click='changePage(parseInt(meta.page) - 1)'
      >
        Previous
      </button>
      <template v-if='meta.total_pages <= 10'>
        <!-- Display all pages if there are 10 or fewer pages -->
        <button
          v-for='pageNumber in meta.total_pages'
          :key='pageNumber'
          :class="{ 'bg-gray-200': pageNumber === parseInt(meta.page) }"
          class='px-3 py-2 mx-1 border rounded hover:bg-gray-300'
          @click='changePage(pageNumber)'
        >
          {{ pageNumber }}
        </button>
      </template>
      <template v-else>
        <!-- Display ellipsis if there are more than 10 pages -->
        <button
          v-for='pageNumber in displayedPages'
          :key='pageNumber'
          :class="{ 'bg-gray-300': pageNumber === parseInt(meta.page) }"
          class='px-3 py-2 mx-1 border rounded hover:bg-gray-300'
          @click='changePage(pageNumber)'
        >
          {{ pageNumber }}
        </button>
        <button
          v-if='meta.page < meta.total_pages'
          class='px-3 py-2 mx-1 border rounded hover:bg-gray-300'
          @click='changePage(parseInt(meta.page) + 1)'
        >
          Next
        </button>
      </template>
    </div>
  </div>

  <div v-else class='mt-6'><h6 class='text-1xl mb-12'>Subscribers list empty</h6></div>
</template>

<script>
export default {
  props: {
    data: {
      type: Array,
      required: true
    },
    meta: {
      type: Object,
      default: {
        total: 0,
        total_pages: 1,
        page: 1,
        limit: 10,
        per_page: 10
      }
    }
  },
  computed: {
    displayedPages() {
      const currentPage = this.meta.page
      const lastPage = this.meta.total_pages
      const visiblePages = 10

      if (currentPage <= visiblePages - 5) {
        return Array.from({ length: visiblePages - 2 }, (_, i) => i + 1)
      } else if (currentPage >= lastPage - visiblePages + 4) {
        return Array.from({ length: visiblePages - 2 }, (_, i) => lastPage - visiblePages + 3 + i)
      } else {
        return Array.from({ length: visiblePages - 4 }, (_, i) => currentPage - 1 + i)
      }
    }

  },
  methods: {
    changePage(newPage) {
      this.$emit('page-change', newPage)
    }
  }
}
</script>

