import { api } from './axios'

export async function getPaginatedSubscribers({ page, limit }) {
  try {
    const response = await api.get(`subscribers?limit=${limit}&page=${page}`)
    return response.data
  } catch (error) {
    throw error
  }
}

export async function getSubscriber(id) {
  try {
    const response = await api.get(`subscribers/${id}`)
    return response.data
  } catch (error) {
    throw error
  }
}


export async function createSubscriber(data) {
  try {
    const resp = await api.post('subscribers', data)
    return resp.data
  } catch (error) {
    throw error
  }
}
