import axios, { AxiosRequestHeaders } from "axios";
import FormData from "form-data";

import { Spreadsheet, Worksheet } from "./jspreadsheetTypes";

import { IClient, IClientConstructor } from "./IClient";
import { IJspreadsheet } from "./IJspreadsheet";
import Jspreadsheet from "./Jspreadsheet";
import { appendObject, axiosRequisitionHandler } from "./utils";

const defaultUrl = "https://jspreadsheet.com/api";

const Client: IClientConstructor = class Client implements IClient {
  token;
  baseUrl;

  constructor(options?: { token?: string; baseUrl?: string }) {
    if (options) {
      this.token = options.token;
    }

    this.baseUrl =
      (options && options.baseUrl) ||
      process.env.JSPREADSHEET_API_BASE_URL ||
      defaultUrl;
  }

  getSpreadsheet(guid: string, worksheetIndex?: number): IJspreadsheet {
    return new Jspreadsheet({
      userSignature: this.token,
      spreadsheetGuid: guid,
      worksheetIndex: worksheetIndex,
      baseUrl: this.baseUrl,
    });
  }

  async create(options?: {
    description?: string;
    config?: Partial<Spreadsheet> | Partial<Worksheet>;
  }) {
    const formData = new FormData();

    if (options) {
      const { description, config } = options;

      if (description) {
        formData.append("description", description);
      }

      if (config) {
        appendObject(formData, config, "config");
      }
    }

    const headers: AxiosRequestHeaders = formData.getHeaders();

    if (this.token) {
      headers.Authorization = `Bearer ${this.token}`;
    }

    const newSpreadsheet = await axiosRequisitionHandler(() =>
      axios.post(`${this.baseUrl}/create`, formData.getBuffer(), {
        headers,
      })
    );

    return new Jspreadsheet({
      userSignature: this.token,
      spreadsheetGuid: newSpreadsheet.data,
      baseUrl: this.baseUrl,
    });
  }

  listSpreadsheets(
    options: {
      offset?: number;
      limit?: number;
      invitations?: boolean;
    } = {}
  ) {
    const headers: AxiosRequestHeaders = {};

    if (this.token) {
      headers.Authorization = `Bearer ${this.token}`;
    }

    return axiosRequisitionHandler(() =>
      axios.get(`${this.baseUrl}/list`, {
        headers,
        params: options,
      })
    );
  }

  async getNewSignature(token: string) {
    const headers: AxiosRequestHeaders = {};

    if (token) {
      headers.Authorization = `Bearer ${token}`;
    }

    const result = await axiosRequisitionHandler(() =>
      axios.get(`${this.baseUrl}/signature`, {
        headers,
      })
    );

    if (result.error) {
      throw new Error(result.message);
    }

    return result.data.signature;
  }

  async getSheetIdWithInvitation(token: string) {
    const headers: AxiosRequestHeaders = {};

    if (token) {
      headers.Authorization = `Bearer ${token}`;
    }

    const result = await axiosRequisitionHandler(() =>
      axios.get(`${this.baseUrl}/invitation`, {
        headers,
      })
    );

    if (result.error) {
      throw new Error(result.message);
    }

    return result.data.sheet_id;
  }
};

export default Client;
