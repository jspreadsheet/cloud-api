import { Spreadsheet, Worksheet } from "./jspreadsheetTypes";

import { IJspreadsheet } from "./IJspreadsheet";

export interface IClientConstructor {
  new (options?: { token?: string; baseUrl?: string }): IClient;
}

export interface IClient {
  /**
   * Creates a new spreadsheet and returns an object that represents it.
   * @param options - New spreadsheet Options.
   */
  create(options?: {
    description?: string;
    config?: Partial<Spreadsheet> | Partial<Worksheet>;
  }): Promise<IJspreadsheet>;

  /**
   * Get an object that represents a spreadsheet.
   * @param guid - spreadsheet guid.
   * @param worksheetIndex - worksheet index. Default is 0.
   */
  getSpreadsheet(guid: string, worksheetIndex?: number): IJspreadsheet;

  /**
   * List this user's spreadsheets.
   */
  listSpreadsheets(): Promise<
    {
      sheet_guid: string;
      sheet_description: string;
      sheet_updated: string;
      sheet_status: number;
      sheet_privacy: number;
    }[]
  >;
}
