<?php
namespace jspreadsheet;

class Spreadsheet
{
    use Merge, Style, Footers, Headers;

    const USER_LEVEL_VIEWER = 1;
    const USER_LEVEL_EDITOR = 2;
    const USER_LEVEL_DESIGNER = 3;

    /**
     * @var Jspreadsheet
     */
    private $client;

    /**
     * Spreadsheet constructor.
     *
     * @param Jspreadsheet controller
     */
    public function __construct(Jspreadsheet $j)
    {
        $this->client = $j;
    }

    /**
     * @param int $tab
     */
    public function setActiveWorksheet($tab)
    {
        $this->client->setActiveWorksheet($tab);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->client->get('config');
    }

    /**
     * @param array $indexes
     * @return Columns
     */
    public function getColumns($indexes = null)
    {
        if (is_array($indexes)) {
            $indexes = implode(',', $indexes);
        }

        return new Columns($this->client, $indexes);
    }

    /**
     * @param int $index
     * @return Columns
     */
    public function getColumn($index)
    {
        return new Columns($this->client, $index);
    }

    /**
     * @param array $indexes
     * @return Rows
     */
    public function getRows($indexes = null)
    {
        if (is_array($indexes)) {
            $indexes = implode(',', $indexes);
        }

        return new Rows($this->client, $indexes);
    }

    /**
     * @param int $index
     * @return Rows
     */
    public function getRow($index)
    {
        return new Rows($this->client, $index);
    }

    /**
     * @return Cells
     */
    public function getCells($indexes = null)
    {
        if (is_array($indexes)) {
            $indexes = implode(',', $indexes);
        }

        return new Cells($this->client, $indexes);
    }

    /**
     * @param string $index
     * @return Cells
     */
    public function getCell($index)
    {
        return new Cells($this->client, $index);
    }

    /**
     * Get a worksheet
     */
    public function getWorksheet($index = 0)
    {
        return new Worksheets($this->client, $index);
    }

    /**
     * @param array $configs
     * @return array
     */
    public function createWorksheet($configs = null)
    {
        return $this->client->post('worksheets/create/', $configs);
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->client->get('users');
    }

    /**
     * @param string $email
     * @param int $level
     * @param bool $notification
     * @return array
     */
    public function addUser($email, $level, $notification = false)
    {
        $users = [
            [
                'email' => $email,
                'level' => $level,
            ]
        ];

        return $this->addUsers($users, $notification);
    }

    /**
     * $users = [
     *   [
     *     'email' => $email,
     *     'level' => $level
     *   ]
     * ];
     *
     * @param array $users
     * @param bool $notification
     * @return array
     */
    public function addUsers($users, $notification = false)
    {
        return $this->client->post('users/', ['data' => $users, 'notification' => $notification]);
    }

    /**
     * @param string $userEmail
     * @param int $level
     * @return array
     */
    public function updateUser($userEmail, $level)
    {
        $users = [
            [ $userEmail, $level ]
        ];

        return $this->updateUsers($users);
    }

    /**
     * $users = [
     *   [ $email, $level ]
     * ];
     *
     * @param array $users
     * @return array
     */
    public function updateUsers($users)
    {
        return $this->client->post('users/update', ['data' => $users]);
    }

    /**
     * @param string $userEmail
     * @return array
     */
    public function deleteUser($userEmail)
    {
        $emails = [ $userEmail ];

        return $this->deleteUsers($emails);
    }

    /**
     * $users = [
     *   [ $email ]
     * ];
     *
     * @param array $userEmails
     * @return array
     */
    public function deleteUsers($userEmails)
    {
        return $this->client->post('users/delete', ['data' => $userEmails]);
    }

    /**
     * $values = [
     *   ['x' => 0, 'y' => 0, 'value' => 'value A1'],
     *   ['x' => 0, 'y' => 1, 'value' => 'value A2']
     * ]
     *
     * @param $values
     * @return array
     */
    public function setValues($values)
    {
        return $this->client->post('value/', $values);
    }
}
