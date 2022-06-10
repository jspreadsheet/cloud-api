import { Column, Nested, Spreadsheet, Worksheet } from "jspreadsheet";

export enum orderByDirection {
  Asc,
  Desc,
}

export interface IJspreadsheetConstructor {
  new ({
    userSignature,
    spreadsheetGuid,
    worksheetIndex,
    baseUrl,
  }: {
    userSignature?: string;
    spreadsheetGuid: string;
    worksheetIndex?: number;
    baseUrl: string;
  }): IJspreadsheet;
}

export interface IJspreadsheet {
  userSignature?: string;
  spreadsheetGuid: string;
  worksheetIndex: number;

  /**
   * Set the worksheetIndex.
   * @param worksheetIndex - New index.
   */
  setWorksheet(worksheetIndex: number): void;

  /**
   * Get all the information from the spreadsheet.
   */
  getConfig(): Promise<Spreadsheet>;

  /**
   * Set up a worksheet configuration. Some properties are set in the spreadsheet.
   * @param config - New worksheet config.
   */
  setConfig(
    config: Worksheet & {
      definedNames?: any;
      toolbar?: any;
      tabs?: any;
    }
  ): Promise<void>;

  /**
   * Get all the data.
   */
  getData(): Promise<
    {
      id: string;
      row: number;
      data: string[];
    }[]
  >;

  /**
   * Reset all data and add new ones.
   * @param data - New data,
   */
  setData(
    data: (
      | string[]
      | {
          row: number;
          data: string[];
        }
    )[]
  ): Promise<void>;

  /**
   * Get the title of one or more headers.
   * @param column - Position of one or more columns. If omitted, all header titles are returned.
   */
  getHeader(column?: number | number[]): Promise<{ [column: number]: string }>;

  /**
   * Set a header title.
   * @param column - Column position.
   * @param title - New title.
   */
  setHeader(column: number, title: string): Promise<void>;

  /**
   * Reset the previous nested header and set a new one.
   * @param nestedHeader - New nested header.
   */
  setNestedHeader(nestedHeader: Nested[][]): Promise<void>;

  /**
   * Set properties of a coordinate that already exists in the nested header.
   * @param x - X coordinate position.
   * @param y - Y coordinate position.
   * @param properties - New nested header cell properties.
   */
  setNestedHeaderCell(x: number, y: number, properties: Nested): Promise<void>;

  /**
   * Remove all nested headers.
   */
  resetNestedHeader(): Promise<void>;

  /**
   * Reset previous footer values and set new values.
   * @param footer - New footer values.
   */
  setFooter(footer: (string | undefined | null)[][]): Promise<void>;

  /**
   * Get all footer values.
   */
  getFooter(): Promise<(string | null)[][] | []>;

  /**
   * Set the value of a pre-existing footer coordinate.
   * @param x - X position.
   * @param y - y position.
   * @param value - New value.
   */
  setFooterValue(x: number, y: number, value: string): Promise<void>;

  /**
   * Remove all footers.
   */
  resetFooter(): Promise<void>;

  /**
   * Set the value of one or more cells.
   * @param data - Array with cell positions and new values.
   */
  setValue(data: { x: number; y: number; value: string }[]): Promise<void>;

  /**
   * Get the value of one or more cells.
   * @param cellNames - Comma-separated cell names and/or ranges.
   */
  getValue(
    cellNames: string
  ): Promise<{ x: number; y: number; name: string; value: string | null }[]>;

  /**
   * Set comments to one or more cells.
   * @param comments - Array with cell names and their new comments. If a cell's new comment is an empty string, the comment will be removed.
   */
  setComment(comments: { cellName: string; value: string }[]): Promise<void>;

  /**
   * Get comments from one or more cells.
   * @param cellNames - Comma-separated cell names and/or ranges. If omitted, all comments are returned.
   */
  getComment(cellNames?: string): Promise<{ [cellName: string]: string }>;

  // /**
  //  * Remove all comments.
  //  */
  // resetComment(): Promise<void>;

  /**
   * Set meta information to one or more cells.
   * @param metas - Array with cell names and their new meta information. If the new value of a meta information is a falsy value, the meta information will be removed.
   */
  setMeta(metas: { cellName: string; value: object | null }[]): Promise<void>;

  /**
   * Get meta information from one or more cells
   * @param cellNames - Comma-separated cell names and/or ranges. If omitted, all meta information is returned.
   */
  getMeta(cellNames?: string): Promise<{ [cellName: string]: object }>;

  /**
   * Remove all meta information.
   */
  resetMeta(): Promise<void>;

  /**
   * Set styles of one or more cells.
   * @param styles - Array with cell names and their new styles. If a style property is sent without a value (with just blank spaces), it will be removed.
   */
  setStyle(styles: { cellName: string; value: string }[]): Promise<void>;

  /**
   * Get styles from one or more cells.
   * @param cellNames - Comma-separated cell names and/or ranges. If omitted, all styles are returned.
   */
  getStyle(cellNames?: string): Promise<{ [cellName: string]: string }>;

  /**
   * Remove all styles from entered cells.
   * @param cellNames - Comma-separated cell names and/or ranges.
   */
  removeStyle(cellNames: string): Promise<void>;

  /**
   * Set a merge.
   * @param merge - New merge.
   * @param merge.cellName - New merge starting cell name.
   * @param merge.colspan - Merge colspan.
   * @param merge.rowspan - Merge rowspan.
   * @param merge.force - Force the insertion of this merge, even if there are conflicts with other merges.
   */
  setMerge(merge: {
    cellName: string;
    colspan: number;
    rowspan: number;
    force?: boolean;
  }): Promise<void>;

  /**
   * Set one or more merges.
   * @param merges - Array with cell names and their merge spans.
   */
  setMerge(
    merges: { cellName: string; spans: [number, number] }[]
  ): Promise<void>;

  /**
   * Get information from one or more merges.
   * @param cellNames - Comma-separated cell names and/or ranges. If omitted, all merges are returned.
   */
  getMerge(
    cellNames?: string
  ): Promise<{ [cellName: string]: [number, number] }>;

  /**
   * Remove the merge in which the entered cell is inserted.
   * @param cellName - Cell name.
   */
  removeMerge(cellName: string): Promise<void>;

  /**
   * Remove all merges
   */
  resetMerge(): Promise<void>;

  /**
   * Insert one or more columns.
   * @param options.data - Inserted column data.
   * @param options.properties - Properties of inserted columns.
   * @param options.insertBefore - Columns must be inserted before the informed position.
   * @param options.numOfColumns - Number of columns to be inserted.
   * @param options.columnNumber - Position in which columns should be inserted.
   */
  insertColumn(options: {
    data?: string[][];
    properties?: Column;
    insertBefore?: boolean;
    numOfColumns: number;
    columnNumber?: number;
  }): Promise<void>;

  /**
   * Move a column to another position.
   * @param from - Column position to be moved.
   * @param to - Position where the column should be moved.
   */
  moveColumn(from: number, to: number): Promise<void>;

  /**
   * Delete one or more adjacent columns.
   * @param columnNumber - Position from which columns should be removed.
   * @param numOfColumns - Number of columns that must be deleted.
   */
  deleteColumn(columnNumber: number, numOfColumns?: number): Promise<void>;

  /**
   * Set the width of one or more columns.
   * @param column - Column position to be changed.
   * @param width - New width.
   */
  setWidth(column: number, width: number): Promise<void>;

  /**
   * Set the width of one or more columns.
   * @param column - Array of column positions to be changed.
   * @param width - New width or new width array.
   */
  setWidth(column: number[], width: number | number[]): Promise<void>;

  /**
   * Get the width of one or more columns.
   * @param columns - One or more column numbers. If omitted, all widths are returned.
   */
  getWidth(
    columns?: number | number[]
  ): Promise<{ [columnNumber: number]: number }>;

  /**
   * Set cell properties.
   * @param column - cell column.
   * @param row - cell row.
   * @param options - new options. If omitted, current options will be removed.
   */
  setProperties(
    column: number,
    row: number,
    options?: { [property: string]: any }
  ): Promise<void>;

  /**
   * Set column properties.
   * @param column - Column number to be updated.
   * @param options - Properties to be set.
   */
  setProperties(column: number, options: Column): Promise<void>;

  /**
   * Delete cell properties.
   * @param column - cell column.
   * @param row - cell row.
   */
  resetProperties(column: number, row: number): Promise<void>;

  /**
   * Get the properties of one cell.
   * @param column - cell x coordinate.
   * @param row - cell y coordinate.
   */
  getProperties(
    column: number,
    row: number
  ): Promise<{ [property: string]: any }>;

  /**
   * Get the properties of one or more columns.
   * @param columns - One or more column numbers. If omitted, all column properties are returned.
   */
  getProperties(
    columns?: number | number[]
  ): Promise<{ [columnIndex: string]: Column }>;

  /**
   * Sort based on a column.
   * @param column - Column number used in sorting.
   * @param direction - Ordering direction.
   */
  orderBy(column: number, direction?: orderByDirection): Promise<void>;

  /**
   * Insert one or more rows.
   * @param options.numOfRows - Number of lines to be inserted.
   * @param options.rowNumber - Position where the rows are to be inserted.
   * @param options.insertBefore - The rows must be inserted before the informed position.
   * @param options.data - New rows data.
   */
  insertRow(options?: {
    numOfRows?: number;
    rowNumber?: number;
    insertBefore?: boolean;
    data?: (
      | { data: { [key: string]: string } | string[] }
      | { [key: string]: string }
      | string[]
    )[];
  }): Promise<{
    numOfRows: number;
    rowNumber: number;
    insertBefore: boolean;
    data: {
      row: number;
      data: string[];
    };
  }>;

  /**
   * Get data from one or more rows.
   * @param rowNumber - Number of one or more rows.
   */
  getRow(
    rowNumber: number | number[]
  ): Promise<{ row: number; data: string[] }[]>;

  /**
   * Move a row to another position.
   * @param from - Position of the row to be moved.
   * @param to - Position where the row should be moved.
   */
  moveRow(from: number, to: number): Promise<void>;

  /**
   * Remove one or more adjacent rows.
   * @param rowNumber - Position from which lines must be removed.
   * @param numOfRows - Number of lines to remove.
   */
  deleteRow(rowNumber: number, numOfRows?: number): Promise<void>;

  /**
   * Set the height of one or more rows.
   * @param row - Number of the row to update.
   * @param height - New row height.
   */
  setHeight(row: number, height: number): Promise<void>;

  /**
   * Set the height of one or more rows.
   * @param row - Array of numbers of rows to be updated.
   * @param height - One or more new heights.
   */
  setHeight(row: number[], height: number | number[]): Promise<void>;

  /**
   * Get the height of one or more rows.
   * @param rowNumber - Number of one or more rows. If omitted, all heights are returned.
   */
  getHeight(
    rowNumber?: number | number[]
  ): Promise<{ [rowNumber: string]: number }>;

  /**
   * Create new worksheet.
   * @param options - Options for this new worksheet.
   */
  createWorksheet(
    options?: Worksheet
  ): Promise<{ worksheet: number; worksheetId: string }>;

  /**
   * Rename worksheet.
   * @param worksheet - Worksheet Position.
   * @param newValue - New worksheet name.
   */
  renameWorksheet(worksheet: number, newValue: string): Promise<void>;

  /**
   * Move a worksheet to another position.
   * @param from - Position of worksheet to be moved.
   * @param to - Position where the worksheet should be moved.
   */
  moveWorksheet(from: number, to: number): Promise<void>;

  /**
   * Delete worksheet.
   * @param worksheetPosition - Worksheet position to be deleted.
   */
  deleteWorksheet(worksheetPosition: number): Promise<void>;

  /**
   * Get all defined names.
   */
  getDefinedName(): Promise<{ [definedName: string]: string }>;

  /**
   * Define new defined names.
   * @param definedNames - New defined names.
   */
  setDefinedName(
    definedNames: { name: string; value: string }[]
  ): Promise<void>;
}
