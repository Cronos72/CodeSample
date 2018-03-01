public class HalloWelt
{

    public static void main(String[] args) 
    {
       Graphm g = new Graphm(Integer.parseInt(args[0]));
       System.out.println("Number of verticies :"+g.getNumberOfVertices());
       System.out.println("Number of edges :"+g.getNumberOfEdges());
       System.out.println("First neigbour :"+g.getFirstNeighbor(0));
       System.out.println("Are nodes 0 and 3 adjacent? :"+g.isAdjacent(0,3));
       System.out.println("The next neigbour of vertex 0 after index j is? j=3 :"+g.getNextNeighbor(0,3));

       
    }
    
}  