import axios, { AxiosInstance, AxiosRequestHeaders } from "axios";
import FormData from "form-data";

import { Column, Nested, Worksheet } from "./jspreadsheetTypes";

import {
  ValidationTypeWithCriteria,
  IJspreadsheet,
  IJspreadsheetConstructor,
  IMapForValidationTypes,
  orderByDirection,
  Validation,
  ValidationAction,
  ValidationTypeWithoutCriteria,
  privacyEnum,
} from "./IJspreadsheet";
import { appendObject, axiosRequisitionHandler } from "./utils";

const Jspreadsheet: IJspreadsheetConstructor = class Jspreadsheet
  implements IJspreadsheet
{
  userSignature;
  spreadsheetGuid;
  worksheetIndex;
  baseUrl;

  private axiosInstance!: AxiosInstance;

  constructor({
    userSignature,
    spreadsheetGuid,
    worksheetIndex,
    baseUrl,
  }: {
    userSignature?: string;
    spreadsheetGuid: string;
    worksheetIndex?: number;
    baseUrl: string;
  }) {
    this.userSignature = userSignature;
    this.spreadsheetGuid = spreadsheetGuid;
    this.baseUrl = baseUrl;

    this.worksheetIndex = worksheetIndex || 0;

    this.setAxiosInstance();
  }

  private setAxiosInstance() {
    const headers: AxiosRequestHeaders = {};

    if (this.userSignature) {
      headers.Authorization = `Bearer ${this.userSignature}`;
    }

    this.axiosInstance = axios.create({
      baseURL: `${this.baseUrl}/${this.spreadsheetGuid},${this.worksheetIndex}`,
      headers,
    });
  }

  setWorksheet(worksheetIndex: number) {
    this.worksheetIndex = worksheetIndex;

    this.setAxiosInstance();
  }

  getConfig() {
    return axiosRequisitionHandler(() => this.axiosInstance.get(""));
  }

  getAllConfig() {
    return axiosRequisitionHandler(() => this.axiosInstance.get("/all"));
  }

  async setConfig(
    config:
      | Partial<Worksheet>
      | {
          definedNames?: any;
          toolbar?: any;
          tabs?: any;
        }
  ) {
    const formData = new FormData();

    if (config) {
      Object.entries(config).forEach(([key, value]) => {
        const valueType = typeof value;
        if (valueType === "object") {
          appendObject(formData, value, key);
        } else if (valueType === "number" || valueType === "string") {
          formData.append(key, value);
        } else if (valueType === "boolean") {
          formData.append(key, value.toString());
        }
      });
    }

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/config", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  getData() {
    return axiosRequisitionHandler(() => this.axiosInstance.get("/data"));
  }

  async setData(
    data: (
      | string[]
      | {
          row: number;
          data: string[];
        }
    )[]
  ) {
    const formData = new FormData();
    appendObject(formData, data, "data");

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/data", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async setHeader(column: number, title: string) {
    const formData = new FormData();

    formData.append("column", column);
    formData.append("title", title);

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/header", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async setNestedHeader(nestedHeader: Nested[][]) {
    const formData = new FormData();
    appendObject(formData, nestedHeader, "data");

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/nested", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async setNestedHeaderCell(x: number, y: number, properties: Nested) {
    const formData = new FormData();

    formData.append("x", x);
    formData.append("y", y);

    appendObject(formData, properties, "properties");

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/nested/update", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async resetNestedHeader(): Promise<void> {
    await axiosRequisitionHandler(() => this.axiosInstance.delete("/nested"));
  }

  getHeaders(column?: number | number[]) {
    let params = "";

    if (typeof column === "number") {
      column = [column];
    }

    if (column) {
      params = "/" + column.join(",");
    }

    return axiosRequisitionHandler(() =>
      this.axiosInstance.get(`/header${params}`)
    );
  }

  getFooters() {
    return axiosRequisitionHandler(() => this.axiosInstance.get("/footers"));
  }

  async setFooters(footer: string[][]) {
    const formData = new FormData();

    appendObject(formData, footer, "data");

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/footers", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async setFooterValue(x: number, y: number, value: string) {
    const formData = new FormData();

    formData.append("x", x);
    formData.append("y", y);
    formData.append("value", value);

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/footers/value", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async resetFooter() {
    await axiosRequisitionHandler(() => this.axiosInstance.delete("/footers"));
  }

  getValue(cellNames: string) {
    return axiosRequisitionHandler(() =>
      this.axiosInstance.get(`/value/${cellNames}`)
    );
  }

  async setValue(data: { x: number; y: number; value: string }[]) {
    const formData = new FormData();

    appendObject(formData, data, "data");

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/value", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  getComments(cellNames?: string) {
    let params = "";

    if (cellNames) {
      params = `/${cellNames}`;
    }

    return axiosRequisitionHandler(() =>
      this.axiosInstance.get(`/comments${params}`)
    );
  }

  async setComments(comments: { cellName: string; value: string }[]) {
    const formData = new FormData();

    comments.forEach(({ cellName, value }) => {
      formData.append(cellName, value);
    });

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/comments", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  // async resetComment() {
  //   await axiosRequisitionHandler(() => this.axiosInstance.delete("/comments"));
  // }

  getMeta(cellNames?: string) {
    let params = "";

    if (cellNames) {
      params = `/${cellNames}`;
    }

    return axiosRequisitionHandler(() =>
      this.axiosInstance.get(`/meta${params}`)
    );
  }

  async setMeta(metas: { cellName: string; value: object | null }[]) {
    const formData = new FormData();

    metas.forEach(({ cellName, value }) => {
      appendObject(formData, value || "", cellName);
    });

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/meta", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async resetMeta() {
    await axiosRequisitionHandler(() => this.axiosInstance.delete("/meta"));
  }

  getStyle(cellNames?: string) {
    let params = "";

    if (cellNames) {
      params = `/${cellNames}`;
    }

    return axiosRequisitionHandler(() =>
      this.axiosInstance.get(`/style${params}`)
    );
  }

  async setStyle(styles: { cellName: string; value: string }[]) {
    const formData = new FormData();

    styles.forEach(({ cellName, value }) => {
      formData.append(cellName, value);
    });

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/style", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async removeStyle(cellNames: string) {
    await axiosRequisitionHandler(() =>
      this.axiosInstance.delete(`/style/${cellNames}`)
    );
  }

  getMerge(cellNames?: string) {
    let params = "";

    if (cellNames) {
      params = `/${cellNames}`;
    }

    return axiosRequisitionHandler(() =>
      this.axiosInstance.get(`/merge${params}`)
    );
  }

  setMerge(merge: {
    cellName: string;
    colspan: number;
    rowspan: number;
    force?: boolean;
  }): Promise<void>;
  setMerge(
    merges: { cellName: string; spans: [number, number] }[]
  ): Promise<void>;
  async setMerge(
    merges:
      | {
          cellName: string;
          colspan: number;
          rowspan: number;
          force?: boolean;
        }
      | { cellName: string; spans: [number, number] }[]
  ) {
    const formData = new FormData();

    if (Array.isArray(merges)) {
      merges.forEach(({ cellName, spans }) => {
        appendObject(formData, spans, cellName);
      });
    } else {
      formData.append("cell", merges.cellName);
      formData.append("colspan", merges.colspan);
      formData.append("rowspan", merges.rowspan);

      if (merges.force) {
        formData.append("force", merges.force.toString());
      }
    }

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/merge", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async removeMerge(cellName: string) {
    if (cellName.startsWith("/") || cellName.trim() === "") {
      throw new Error(
        "These arguments would result in all merges being removed. To remove all merges, use the resetMerge method"
      );
    }

    await axiosRequisitionHandler(() =>
      this.axiosInstance.delete(`/merge/${cellName}`)
    );
  }

  async resetMerge() {
    await axiosRequisitionHandler(() => this.axiosInstance.delete(`/merge`));
  }

  async insertColumn({
    data,
    properties,
    insertBefore,
    numOfColumns,
    columnNumber,
  }: {
    data?: string[][];
    properties?: Column[];
    insertBefore?: boolean;
    numOfColumns: number;
    columnNumber?: number;
  }) {
    const formData = new FormData();

    formData.append("numOfColumns", numOfColumns);

    if (columnNumber) {
      formData.append("columnNumber", columnNumber);
    }

    if (insertBefore) {
      formData.append("insertBefore", insertBefore.toString());
    }

    if (data) {
      appendObject(formData, data, "data");
    }

    if (properties) {
      appendObject(formData, properties, "properties");
    }

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/columns", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async moveColumn(from: number, to: number) {
    const formData = new FormData();

    formData.append("f", from);
    formData.append("t", to);

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/columns/move", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async deleteColumn(columnNumber: number, numOfColumns?: number) {
    const formData = new FormData();

    formData.append("columnNumber", columnNumber);

    if (numOfColumns) {
      formData.append("numOfColumns", numOfColumns);
    }

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/columns/delete", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  getWidth(columns?: number | number[]) {
    let params = "";

    if (Array.isArray(columns)) {
      params = "/" + columns.join(",");
    } else if (typeof columns === "number") {
      params = "/" + columns;
    }

    return axiosRequisitionHandler(() =>
      this.axiosInstance.get(`/width${params}`)
    );
  }

  setWidth(column: number, width: number): Promise<void>;
  setWidth(column: number[], width: number | number[]): Promise<void>;
  async setWidth(column: number | number[], width: number | number[]) {
    const formData = new FormData();

    if (Array.isArray(column)) {
      appendObject(formData, column, "column");

      if (Array.isArray(width)) {
        appendObject(formData, width, "width");
      } else {
        formData.append("width", width);
      }
    } else {
      formData.append("column", column);
      formData.append("width", width as number);
    }

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/width", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  getProperty(
    column: number,
    row: number
  ): Promise<{ [property: string]: any }>;
  getProperty(
    columns?: number | number[]
  ): Promise<{ [columnIndex: string]: Column }>;
  getProperty(column?: number | number[], row?: number) {
    let params = "";

    if (Array.isArray(column)) {
      params = "/" + column.join(",");
    } else if (typeof column === "number") {
      params = "/" + column;
    }

    if (row !== undefined) {
      params += "/" + row;
    }

    return axiosRequisitionHandler(() =>
      this.axiosInstance.get(`/properties${params}`)
    );
  }

  setProperty(
    properties: {
      column: number;
      row: number;
      options?: { [property: string]: any };
    }[]
  ): Promise<void>;
  setProperty(
    properties: { column: number; options?: Column }[]
  ): Promise<void>;
  async setProperty(
    properties: {
      column: number;
      row?: number;
      options?: Column | { [property: string]: any };
    }[]
  ): Promise<void> {
    const formData = new FormData();

    properties.forEach(({ column, row, options }, index) => {
      formData.append(`data[${index}][x]`, column);

      if (typeof row === "number") {
        formData.append(`data[${index}][y]`, row);
      }

      if (options) {
        appendObject(formData, options, `data[${index}][value]`);
      }
    });

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/properties", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  updateProperty(
    properties: {
      column: number;
      row: number;
      options: { [property: string]: any };
    }[]
  ): Promise<void>;
  updateProperty(
    properties: { column: number; options: Column }[]
  ): Promise<void>;
  async updateProperty(
    properties: {
      column: number;
      row?: number;
      options: Column | { [property: string]: any };
    }[]
  ) {
    const formData = new FormData();

    properties.forEach(({ column, row, options }, index) => {
      formData.append(`data[${index}][x]`, column);

      if (typeof row === "number") {
        formData.append(`data[${index}][y]`, row);
      }

      appendObject(formData, options, `data[${index}][value]`);
    });

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/properties/update", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  resetProperties(column: number, row: number): Promise<void> {
    return this.setProperty([
      {
        column,
        row,
      },
    ]);
  }

  async orderBy(column: number, direction?: orderByDirection) {
    const formData = new FormData();

    formData.append("column", column);

    if (Number.isInteger(direction)) {
      formData.append("direction", direction);
    }

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/orderby", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  getRow(rowNumber: number | number[]) {
    let params = "";

    if (Array.isArray(rowNumber)) {
      params = "/" + rowNumber.join(",");
    } else if (typeof rowNumber === "number") {
      params = "/" + rowNumber;
    }

    return axiosRequisitionHandler(() =>
      this.axiosInstance.get(`/rows${params}`)
    );
  }

  async insertRow(options?: {
    numOfRows?: number;
    rowNumber?: number;
    insertBefore?: boolean;
    data?: (
      | { data: { [key: string]: string } | string[] }
      | { [key: string]: string }
      | string[]
    )[];
  }) {
    const formData = new FormData();

    if (options) {
      const { numOfRows, rowNumber, insertBefore, data } = options;

      if (Number.isInteger(numOfRows)) {
        formData.append("numOfRows", numOfRows);
      }

      if (Number.isInteger(rowNumber)) {
        formData.append("rowNumber", rowNumber);
      }

      if (typeof insertBefore === "boolean") {
        formData.append("insertBefore", insertBefore.toString());
      }

      if (data) {
        appendObject(formData, data, "data");
      }
    }

    const insertedRows = await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/rows", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );

    insertedRows.data.insertBefore = insertedRows.data.insertBefore === 1;

    return insertedRows.data;
  }

  async moveRow(from: number, to: number) {
    const formData = new FormData();

    formData.append("f", from);
    formData.append("t", to);

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/rows/move", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async deleteRow(rowNumber: number, numOfRows?: number): Promise<void> {
    const formData = new FormData();

    formData.append("rowNumber", rowNumber);

    if (numOfRows) {
      formData.append("numOfRows", numOfRows);
    }

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/rows/delete", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  getHeight(rowNumber?: number | number[]) {
    let params = "";

    if (Array.isArray(rowNumber)) {
      params = "/" + rowNumber.join(",");
    } else if (typeof rowNumber === "number") {
      params = "/" + rowNumber;
    }

    return axiosRequisitionHandler(() =>
      this.axiosInstance.get(`/height${params}`)
    );
  }

  setHeight(row: number, height: number): Promise<void>;
  setHeight(row: number[], height: number | number[]): Promise<void>;
  async setHeight(row: number | number[], height: number | number[]) {
    const formData = new FormData();

    if (Array.isArray(row)) {
      appendObject(formData, row, "row");

      if (Array.isArray(height)) {
        appendObject(formData, height, "height");
      } else {
        formData.append("height", height);
      }
    } else {
      formData.append("row", row);
      formData.append("height", height as number);
    }

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/height", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async createWorksheet(options?: Partial<Worksheet>) {
    const formData = new FormData();

    if (options) {
      Object.entries(options).forEach(([key, value]) => {
        const valueType = typeof value;
        if (valueType === "object") {
          appendObject(formData, value, key);
        } else if (valueType === "number" || valueType === "string") {
          formData.append(key, value);
        } else if (valueType === "boolean") {
          formData.append(key, value.toString());
        }
      });
    }

    const result = await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/worksheets", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );

    return result.data;
  }

  async renameWorksheet(worksheet: number, newValue: string) {
    const formData = new FormData();

    formData.append("worksheet", worksheet);
    formData.append("newValue", newValue);

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/worksheets/rename", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async moveWorksheet(from: number, to: number): Promise<void> {
    const formData = new FormData();

    formData.append("f", from);
    formData.append("t", to);

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/worksheets/move", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async deleteWorksheet(worksheetPosition: number): Promise<void> {
    await axiosRequisitionHandler(() =>
      this.axiosInstance.delete(`/worksheets/${worksheetPosition}`)
    );
  }

  getDefinedNames() {
    return axiosRequisitionHandler(() => this.axiosInstance.get("/names"));
  }

  async setDefinedNames(definedNames: { name: string; value: string }[]) {
    const formData = new FormData();

    definedNames.forEach(({ name, value }, index) => {
      formData.append(`data[${index}][index]`, name);
      formData.append(`data[${index}][value]`, value);
    });

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/names", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async getValidations(): Promise<
    Validation<
      keyof IMapForValidationTypes | ValidationTypeWithoutCriteria,
      ValidationAction
    >[]
  > {
    return axiosRequisitionHandler(() =>
      this.axiosInstance.get("/validations")
    );
  }

  async setValidations<
    Type extends ValidationTypeWithCriteria | ValidationTypeWithoutCriteria,
    Action extends ValidationAction
  >(
    validations: {
      index: number;
      value: Validation<Type, Action>;
    }[]
  ): Promise<void> {
    const formData = new FormData();

    validations.forEach(
      ({ index: validationIndex, value: validation }, index) => {
        formData.append(`data[${index}][index]`, validationIndex);

        appendObject(formData, validation, `data[${index}][value]`);
      }
    );

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/validations", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async getFreezeRows() {
    return axiosRequisitionHandler(() =>
      this.axiosInstance.get("/freeze/rows")
    );
  }

  async setFreezeRows(row: number) {
    const formData = new FormData();

    formData.append("row", row);

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/freeze/rows", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async getFreezeColumns() {
    return axiosRequisitionHandler(() =>
      this.axiosInstance.get("/freeze/columns")
    );
  }

  async setFreezeColumns(column: number) {
    const formData = new FormData();

    formData.append("column", column);

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/freeze/columns", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  getHistory() {
    return axiosRequisitionHandler(() => this.axiosInstance.get("/history"));
  }

  async setHistory() {
    const formData = new FormData();

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/history", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  getVersion(versionId: string) {
    return axiosRequisitionHandler(() =>
      this.axiosInstance.get(`/history/${versionId}`)
    );
  }

  recoverVersion(versionId: string) {
    const formData = new FormData();

    return axiosRequisitionHandler(() =>
      this.axiosInstance.post(
        `/history/recover/${versionId}`,
        formData.getBuffer(),
        {
          headers: formData.getHeaders(),
        }
      )
    );
  }

  async deleteVersion(versionId: string) {
    await axiosRequisitionHandler(() =>
      this.axiosInstance.delete(`/history/${versionId}`)
    );
  }

  async getName() {
    const result = await axiosRequisitionHandler(() =>
      this.axiosInstance.get(`/name`)
    );

    return result.name;
  }

  setName(name?: string) {
    const formData = new FormData();

    if (name) {
      formData.append("data", name);
    }

    return axiosRequisitionHandler(() =>
      this.axiosInstance.post(`/name`, formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  getPrivacy() {
    return axiosRequisitionHandler(() => this.axiosInstance.get("/privacy"));
  }

  async setPrivacy(privacy: privacyEnum) {
    const formData = new FormData();

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post(`/privacy/${privacy}`, formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async delete() {
    await axiosRequisitionHandler(() => this.axiosInstance.delete(""));
  }

  getUsers() {
    return axiosRequisitionHandler(() => this.axiosInstance.get("/users"));
  }

  async setUsers(users: { email: string; level: number }[]) {
    const formData = new FormData();

    appendObject(formData, users, "data");

    const result = await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/users", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );

    return result.data.users;
  }

  async updateUsers(users: { email: string; level: number }[]) {
    const formData = new FormData();

    const reqBody = users.map((user) => [user.email, user.level]);

    appendObject(formData, reqBody, "data");

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/users/update", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }

  async deleteUsers(users: string | string[]) {
    if (typeof users === "string") {
      users = [users];
    }

    const formData = new FormData();

    appendObject(formData, users, "data");

    await axiosRequisitionHandler(() =>
      this.axiosInstance.post("/users/delete", formData.getBuffer(), {
        headers: formData.getHeaders(),
      })
    );
  }
};

export default Jspreadsheet;
