import axios, { AxiosRequestConfig, AxiosResponse } from 'axios';
import { Department } from './departments/department';


export const useAPI = () => {

  async function searchDepartments(): Promise<Department[]> {
    const config = {
      method: 'get',
      url: 'http://startup-backend.test/api/departments'
    };

    return await handleRequest<Department>(config);
  }

  return {
    searchDepartments
  };
};


async function send(req: AxiosRequestConfig): Promise<AxiosResponse<any, any>> {
    try {
      return await axios(req);
    } catch (e: any) {
      throw e;
    }
  }


export async function handleRequest<T>(req: AxiosRequestConfig): Promise<T[]> {
  const response = await send(req);
  return  response.data;
}
