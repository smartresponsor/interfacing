import { Card, Typography } from 'antd';

export default function App(): JSX.Element {
  return (
    <main style={{ padding: 24 }}>
      <Card>
        <Typography.Title level={2}>Interfacing Workspace Upstream</Typography.Title>
        <Typography.Paragraph>
          PrimeReact facade and Ant Design + ProComponents workbench will be grown here under zone governance.
        </Typography.Paragraph>
      </Card>
    </main>
  );
}
