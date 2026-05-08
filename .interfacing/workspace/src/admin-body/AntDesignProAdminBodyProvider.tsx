import React from 'react';
import { createRoot, Root } from 'react-dom/client';
import { Button, Card, ConfigProvider, Descriptions, Space, Tag, Typography, message } from 'antd';
import { PageContainer, ProForm, ProFormText, ProTable, ProColumns } from '@ant-design/pro-components';
import 'antd/dist/reset.css';
import type { AdminBodyProvider, AdminBodySchema } from './types';
import { getOperation, getResourceLabel, getRows } from './types';

const rootRegistry = new WeakMap<HTMLElement, Root>();

function buildColumns(schema: AdminBodySchema): ProColumns<Record<string, unknown>>[] {
  const declared = schema.resourceContract?.columns;
  const base = Array.isArray(declared) && declared.length > 0
    ? declared.map((column) => ({
        title: column.title || column.key || column.dataIndex || 'Column',
        dataIndex: column.dataIndex || column.key || 'title',
        key: column.key || column.dataIndex || 'title',
        ellipsis: true,
      }))
    : [
        { title: 'Title', dataIndex: 'title', key: 'title', ellipsis: true },
        { title: 'Status', dataIndex: 'status', key: 'status', render: (_, row) => <Tag>{String(row.status || 'ready')}</Tag> },
        { title: 'Locale', dataIndex: 'locale', key: 'locale' },
      ];

  return [
    ...base,
    {
      title: 'Actions',
      valueType: 'option',
      key: 'option',
      render: (_, row) => (
        <Space size="small">
          <Button type="link" size="small">View</Button>
          <Button type="link" size="small">Edit</Button>
          <Button type="link" danger size="small">Delete</Button>
        </Space>
      ),
    },
  ];
}

function ListWorkbench({ schema }: { schema: AdminBodySchema }): React.ReactElement {
  const rows = getRows(schema);
  return (
    <ProTable<Record<string, unknown>>
      rowKey={(row) => String(row.id || row.key || row.title)}
      columns={buildColumns(schema)}
      dataSource={rows}
      search={{ labelWidth: 'auto' }}
      options={{ density: true, fullScreen: true, reload: false, setting: true }}
      pagination={{ pageSize: 10, showSizeChanger: true }}
      rowSelection={{}}
      toolbar={{
        title: getResourceLabel(schema),
        actions: [
          <Button key="locale">Content locale: {String(schema.contentLocale || 'en')}</Button>,
          <Button key="cards">Cards</Button>,
          <Button key="create" type="primary">Create new</Button>,
        ],
      }}
    />
  );
}

function FormWorkbench({ schema }: { schema: AdminBodySchema }): React.ReactElement {
  const fields = schema.resourceContract?.formFields || [
    { name: 'title', label: 'Title', required: true },
    { name: 'slug', label: 'Slug' },
    { name: 'status', label: 'Status' },
  ];

  return (
    <Card>
      <ProForm
        onFinish={async () => {
          message.success('Form submit intent captured by canonical provider');
          return true;
        }}
        submitter={{ searchConfig: { submitText: 'Save', resetText: 'Reset' } }}
      >
        {fields.map((field) => (
          <ProFormText
            key={String(field.name || field.label)}
            name={String(field.name || field.label)}
            label={String(field.label || field.name)}
            rules={field.required ? [{ required: true }] : undefined}
          />
        ))}
      </ProForm>
    </Card>
  );
}

function DetailWorkbench({ schema }: { schema: AdminBodySchema }): React.ReactElement {
  const rows = getRows(schema);
  const current = rows[0] || {};

  return (
    <Card>
      <Descriptions title="Details" bordered column={1}>
        {Object.entries(current).map(([key, value]) => (
          <Descriptions.Item key={key} label={key}>{String(value)}</Descriptions.Item>
        ))}
      </Descriptions>
    </Card>
  );
}

function CardsWorkbench({ schema }: { schema: AdminBodySchema }): React.ReactElement {
  return (
    <Space direction="vertical" style={{ width: '100%' }}>
      {getRows(schema).map((row) => (
        <Card key={String(row.id || row.title)} title={String(row.title || row.id)} extra={<Button type="link">Edit</Button>}>
          <Typography.Text>Status: {String(row.status || 'ready')}</Typography.Text>
        </Card>
      ))}
    </Space>
  );
}

function AdminBodyApp({ schema }: { schema: AdminBodySchema }): React.ReactElement {
  const operation = getOperation(schema);
  const title = getResourceLabel(schema);
  const view = schema.defaultView || 'table';

  let content: React.ReactElement;
  if (operation === 'new' || operation === 'edit') {
    content = <FormWorkbench schema={schema} />;
  } else if (operation === 'show') {
    content = <DetailWorkbench schema={schema} />;
  } else if (view === 'cards') {
    content = <CardsWorkbench schema={schema} />;
  } else {
    content = <ListWorkbench schema={schema} />;
  }

  return (
    <ConfigProvider>
      <PageContainer
        title={title}
        subTitle={`Operation: ${operation}`}
        extra={[<Button key="back">Back to list</Button>, <Button key="create" type="primary">Create new</Button>]}
      >
        {content}
      </PageContainer>
    </ConfigProvider>
  );
}

export function createAntDesignProAdminBodyProvider(): AdminBodyProvider {
  return {
    mount(mount: HTMLElement, schema: AdminBodySchema): void {
      let root = rootRegistry.get(mount);
      if (!root) {
        root = createRoot(mount);
        rootRegistry.set(mount, root);
      }

      root.render(<AdminBodyApp schema={schema} />);
      mount.dataset.adminBodyHydration = 'ready';
    },
  };
}
