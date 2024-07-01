import React, { useCallback, useEffect, useState } from 'react';
import { Anchor, GetProp, Layout, Menu, Radio, RadioChangeEvent, Select, Table, TableColumnsType, TablePaginationConfig, TableProps, theme } from 'antd';
import type { SorterResult } from 'antd/es/table/interface';
import { Department } from './clients/departments/department';
import { useAPI } from './clients/backend-client';
import { debounce } from 'lodash';

const { Header, Content } = Layout;

const items = [
  {
    key: 1,
    label: `Dashboard`,
  },
  {
    key: 2,
    label: `Organización`,
  },
  {
    key: 3,
    label: `Modelos`,
  },
  {
    key: 4,
    label: `Seguimiento`,
  }];

type TableRowSelection<T> = TableProps<T>['rowSelection'];

interface TableParams {
  pagination?: TablePaginationConfig;
  sortField?: SorterResult<any>['field'];
  sortOrder?: SorterResult<any>['order'];
  filters?: Parameters<GetProp<TableProps, 'onChange'>>[1];
}

type OnChange = NonNullable<TableProps<Department>['onChange']>;
type Filters = Parameters<OnChange>[1];

type GetSingle<T> = T extends (infer U)[] ? U : never;
type Sorts = GetSingle<Parameters<OnChange>[2]>;



const App: React.FC = () => {
  
  const { searchDepartments } = useAPI(); 
  const [value3, setValue3] = useState('Listado');
  const [filteredInfo, setFilteredInfo] = useState<Filters>({});
  const [sortedInfo, setSortedInfo] = useState<Sorts>({});
  const [selectedRowKeys, setSelectedRowKeys] = useState<React.Key[]>([]);
  const [data, setData] = useState<Department[]>();
  const [deparmentsNames, setDeparmentsNames] = useState<string[]>([]);
  const [tableParams, setTableParams] = useState<TableParams>({
      pagination: {
        current: 1,
        pageSize: 10,
      },
});

const columns: TableColumnsType<Department> = [
  {
    title: 'División',
    dataIndex: 'department_name',
    key: 'department_name',
    sorter: (a, b) => a.department_name.localeCompare(b.department_name),
    filters: data ? data.map((department) => ({ text: department.department_name, value: department.department_name })) : [],
    onFilter: (value, record) => record.department_name.startsWith(value as string),
  },
  {
    title: 'División Superior', 
    dataIndex: 'superior_department_name',
    key: 'superior_department_name',
    sorter: (a, b) => a.superior_department_name.localeCompare(b.superior_department_name),
    filters: data ? [...new Set(data.map((department) => (department.superior_department_name)))].map((name) => ({text: name, value: name })) : [],
    onFilter: (value, record) => record.superior_department_name.startsWith(value as string),
  },
  {
    title: 'Colaboradores',
    dataIndex: 'employee_count',
    key: 'employee_count',  
    sorter: (a, b) => a.employee_count - b.employee_count
  },
  {
    title: 'Nivel',
    dataIndex: 'level',
    key: 'level',
    sorter: (a, b) => a.level - b.level,
  },
  {
    title: 'Subdivisiones',
    dataIndex: 'subdepartments_total',
    key: 'subdepartments_total',
    sorter: (a, b) => a.subdepartments_total - b.subdepartments_total,
  },
  {
    title: 'Embajadores',
    dataIndex: 'ambassador_name',
    key: 'ambassador_name',
  },
];

  const {
    token: { colorBgContainer },
  } = theme.useToken();

  const layoutStyle = {
    overflow: 'hidden',
    width: '100%',
    height: '100%'
  };

  const options = [
    { label: 'Listado', value: 'Listado' },
    { label: 'Árbol', value: 'Árbol' },
  ];

  const onChangeRadioGroup = ({ target: { value } }: RadioChangeEvent) => {
    console.log('radio3 checked', value);
    setValue3(value);
  };

  const handleColmnsChange = (value: string) => {
    console.log(`selected ${value}`);
  };

  const onSelectChange = (newSelectedRowKeys: React.Key[]) => {
    console.log('selectedRowKeys changed: ', newSelectedRowKeys);
    setSelectedRowKeys(newSelectedRowKeys);
  };

  const rowSelection: TableRowSelection<Department> = {
    selectedRowKeys,
    onChange: onSelectChange,
  };

  const onChange = (value: string) => {
    console.log(`selected ${value}`);
  };
  
  const onSearch = (value: string) => {
    console.log('search:', value);
  };

  const getDeparments = useCallback(
    debounce(function () {
      searchDepartments()
        .then((response) => {
          setData(response);
        })
        .catch(() => {
          setData([]);
        });
    }, 500),
    [],
  );


  useEffect(() => {
    getDeparments();
  }, [
    tableParams.pagination?.current,
    tableParams.pagination?.pageSize,
    tableParams?.sortOrder,
    tableParams?.sortField,
    JSON.stringify(tableParams.filters),
  ]);

  const onChangeTable: TableProps<Department>['onChange'] = (pagination, filters, sorter, extra) => {
    console.log('params', pagination, filters, sorter, extra);
    setTableParams({
      pagination: pagination
})
  };

  return (
    <Layout style={layoutStyle}>
      <Header style={{ display: 'flex', alignItems: 'center' }}>
        <div className="demo-logo" />
        <Menu
          theme="dark"
          mode="horizontal"
          defaultSelectedKeys={['2']}
          items={items}
          style={{ flex: 1, minWidth: 0 }}
        />
      </Header>
      <Content>
        
        <div
          style={{
            background: colorBgContainer,
            minHeight: 70,
            paddingTop: 5,
            paddingLeft: 24,
            paddingRight: 24,
          }}
        >
          <h3>Organización</h3>

          <div >
            <Anchor
              affix={false}
              direction="horizontal"
              items={[
                {
                  key: 'Divisiones',
                  href: '#',
                  title: 'Divisiones',
                },
                {
                  key: 'Colaboradores',
                  href: '#part-2',
                  title: 'Colaboradores',
                },
              ]}
            />
          </div>
        </div>
        <div
          style={{
            minHeight: 100,
            height:'100%',
            paddingTop: 27,
            paddingLeft: 35,
            paddingRight: 35
          }}
        >
        <div 
          style={{
            display: 'flex',
            justifyContent: 'space-between',
            width: '100%',
            paddingBottom: 20
          }}>
          <Radio.Group options={options} onChange={onChangeRadioGroup} value={value3} optionType="button" />
          <div 
            style={{
              display: 'flex' 
            }}> 
            <div 
            style={{
              paddingRight: 20
            }}>
              <Select
              placeholder='Columnas'
              style={{ width: 120 }}
              onChange={handleColmnsChange}
              options={[
                { value: '1', label: 'División' },
                { value: '2', label: 'División Superior' },
                { value: '3', label: 'Colaboradores' },
                { value: '4', label: 'Nivel'},
                { value: '4', label: 'Subdiviaiones'},
                { value: '4', label: 'Embajadores'},
              ]}
            />
            </div>
            
            <Select
                showSearch
                placeholder="Buscar"
                optionFilterProp="label"
                onChange={onChange}
                onSearch={onSearch}
              />
          </div>
        </div>

        <Table rowSelection={rowSelection} columns={columns} dataSource={data} pagination={tableParams.pagination} onChange={onChangeTable}/>
        </div>
      </Content>
    </Layout>
  );
};

export default App;