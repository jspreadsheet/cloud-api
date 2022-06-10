import { AxiosResponse } from "axios";
import FormData from "form-data";

export function appendObject(
  formData: FormData,
  propertyValue: any,
  propertyName: string
) {
  if (Array.isArray(propertyValue)) {
    propertyValue.forEach((item, index) => {
      appendObject(formData, item, propertyName + `[${index}]`);
    });
  } else if (typeof propertyValue === "object") {
    if (propertyValue) {
      Object.entries(propertyValue).forEach(([key, value]) => {
        appendObject(formData, value, propertyName + `[${key}]`);
      });
    }
  } else {
    if (propertyValue !== undefined && propertyValue !== null) {
      formData.append(propertyName, propertyValue.toString());
    }
  }
}

export async function axiosRequisitionHandler(
  axiosCall: () => Promise<AxiosResponse>
): Promise<any> {
  try {
    const result = await axiosCall();

    return result.data;
  } catch (err: any) {
    if (err.response) {
      if (err.response.data.message) {
        throw new Error(err.response.data.message);
      } else {
        throw new Error(err.response.statusText);
      }
    } else if (err.request) {
      throw new Error("Couldn't connect to server");
    } else {
      throw new Error(
        `An error occurred in this method. Please report this to the development team: ${err.message}`
      );
    }
  }
}
